<?php

namespace App\Controllers;

use App\Models\CongeModel;
use App\Models\EmployeModel;
use App\Models\TypeCongeModel;
use App\Models\SoldeCongeModel;
use App\Models\NotificationModel;
use App\Models\ActivityLogModel;

class CongeController extends BaseController
{
    protected $model;
    protected $notif;
    protected $log;

    public function __construct()
    {
        $this->model = new CongeModel();
        $this->notif = new NotificationModel();
        $this->log   = new ActivityLogModel();
    }

    private function idEmp(): int { return (int) session()->get('id_Emp'); }
    private function idPfl(): int { return (int) session()->get('id_Pfl'); }

    private function getRHIds(): array
    {
        $db = \Config\Database::connect();
        return array_column(
            $db->table('employe')->where('id_Pfl', 1)->get()->getResultArray(),
            'id_Emp'
        );
    }

    private function getChefIds(): array
    {
        $db = \Config\Database::connect();
        return array_column(
            $db->table('employe')->where('id_Pfl', 2)->get()->getResultArray(),
            'id_Emp'
        );
    }

    // ── INDEX ─────────────────────────────────────────────────
    public function index()
    {
        $db    = \Config\Database::connect();
        $idPfl = $this->idPfl();
        $idEmp = $this->idEmp();

        $query = $db->table('conge')
            ->select('conge.*, employe.Nom_Emp, employe.Prenom_Emp,
                      employe.id_Dir, direction.Nom_Dir,
                      type_conge.Libelle_Tcg')
            ->join('employe',    'employe.id_Emp = conge.id_Emp',     'left')
            ->join('direction',  'direction.id_Dir = employe.id_Dir', 'left')
            ->join('type_conge', 'type_conge.id_Tcg = conge.id_Tcg', 'left');

        if ($idPfl == 3) {
            $query->where('conge.id_Emp', $idEmp);
        }

        if ($idPfl == 2) {
            $emp = (new EmployeModel())->find($idEmp);
            $query->groupStart()
                    ->where('conge.id_Emp', $idEmp)
                    ->orGroupStart()
                        ->where('employe.id_Dir', $emp['id_Dir'])
                        ->where('conge.id_Emp !=', $idEmp)
                    ->groupEnd()
                  ->groupEnd();
        }

        $conges = $query->orderBy('conge.DateDemande_Cge', 'DESC')
                        ->get()->getResultArray();

        $data['directions'] = $db->table('direction')
                                 ->orderBy('Nom_Dir', 'ASC')
                                 ->get()->getResultArray();

        $data['typesConge'] = $db->table('type_conge')
                                 ->orderBy('Libelle_Tcg', 'ASC')
                                 ->get()->getResultArray();

        $data['title']  = 'Conges';
        $data['conges'] = $conges;
        $data['idPfl']  = $idPfl;
        $data['idEmp']  = $idEmp;

        return view('rh/conge/index', $data);
    }

    // ── SHOW ──────────────────────────────────────────────────
    public function show($id)
    {
        $db    = \Config\Database::connect();
        $idPfl = $this->idPfl();
        $idEmp = $this->idEmp();

        $conge = $db->table('conge')
            ->select('conge.*,
                      employe.Nom_Emp, employe.Prenom_Emp,
                      employe.Email_Emp, employe.id_Dir,
                      employe.id_Pfl AS Pfl_Demandeur,
                      direction.Nom_Dir,
                      type_conge.Libelle_Tcg,
                      validChef.Nom_Emp    AS NomValidChef,
                      validChef.Prenom_Emp AS PrenomValidChef,
                      validRH.Nom_Emp      AS NomValidRH,
                      validRH.Prenom_Emp   AS PrenomValidRH')
            ->join('employe',    'employe.id_Emp = conge.id_Emp',                   'left')
            ->join('direction',  'direction.id_Dir = employe.id_Dir',               'left')
            ->join('type_conge', 'type_conge.id_Tcg = conge.id_Tcg',               'left')
            ->join('employe validChef', 'validChef.id_Emp = conge.id_Emp_ValidDir', 'left')
            ->join('employe validRH',   'validRH.id_Emp   = conge.id_Emp_ValidRH',  'left')
            ->where('conge.id_Cge', $id)
            ->get()->getRowArray();

        if (!$conge) {
            return redirect()->to('conge')->with('error', 'Conge introuvable.');
        }

        if ($idPfl == 3 && $conge['id_Emp'] != $idEmp) {
            return redirect()->to('conge')->with('error', 'Acces refuse.');
        }

        if ($idPfl == 2) {
            $emp = (new EmployeModel())->find($idEmp);
            if ($conge['id_Emp'] != $idEmp && $conge['id_Dir'] != $emp['id_Dir']) {
                return redirect()->to('conge')->with('error', 'Acces refuse.');
            }
        }

        $data['title'] = 'Detail Conge';
        $data['conge'] = $conge;
        $data['idPfl'] = $idPfl;
        $data['idEmp'] = $idEmp;

        return view('rh/conge/show', $data);
    }

    // ── CREATE ────────────────────────────────────────────────
    public function create()
    {
        $idPfl = $this->idPfl();
        $idEmp = $this->idEmp();

        $solde = (new SoldeCongeModel())
            ->where('id_Emp', $idEmp)
            ->where('Annee_Sld', date('Y'))
            ->first();

        $data['title']      = 'Nouvelle Demande de Conge';
        $data['typesConge'] = (new TypeCongeModel())->findAll();
        $data['solde']      = $solde;
        $data['idPfl']      = $idPfl;

        if ($idPfl == 1) {
            $data['employes'] = (new EmployeModel())->findAll();
        }

        return view('rh/conge/create', $data);
    }

    // ── STORE ─────────────────────────────────────────────────
    public function store()
    {
        $idPfl = $this->idPfl();
        $idEmp = $this->idEmp();

        $rules = [
            'id_Tcg'        => 'required',
            'Libelle_Cge'   => 'required|min_length[3]',
            'DateDebut_Cge' => 'required',
            'DateFin_Cge'   => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()
                             ->with('errors', $this->validator->getErrors());
        }

        $debut = $this->request->getPost('DateDebut_Cge');
        $fin   = $this->request->getPost('DateFin_Cge');

        if ($fin < $debut) {
            return redirect()->back()->withInput()
                             ->with('error', 'La date de fin doit etre apres la date de debut.');
        }

        $idEmpCible = ($idPfl == 1 && $this->request->getPost('id_Emp'))
            ? (int) $this->request->getPost('id_Emp')
            : $idEmp;

        $demandeur = (new EmployeModel())->find($idEmpCible);

        $soldeModel = new SoldeCongeModel();
        $solde = $soldeModel
            ->where('id_Emp', $idEmpCible)
            ->where('Annee_Sld', date('Y'))
            ->first();

        $nbJours = (new \DateTime($debut))->diff(new \DateTime($fin))->days + 1;

        if ($solde) {
            $restant = $solde['NbJoursDroit_Sld'] - $solde['NbJoursPris_Sld'];
            if ($nbJours > $restant) {
                return redirect()->back()->withInput()
                                 ->with('error', "Solde insuffisant. Il reste {$restant} jour(s) disponible(s).");
            }
        }

        $statutInitial   = 'en_attente';
        $idEmpValidDir   = null;
        $dateDecisionDir = null;

        if ($idPfl == 1 && $idEmpCible == $idEmp) {
            $statutInitial   = 'approuve_chef';
            $idEmpValidDir   = $idEmp;
            $dateDecisionDir = date('Y-m-d H:i:s');
        }

        $id = $this->model->insert([
            'id_Tcg'              => $this->request->getPost('id_Tcg'),
            'Libelle_Cge'         => $this->request->getPost('Libelle_Cge'),
            'DateDebut_Cge'       => $debut,
            'DateFin_Cge'         => $fin,
            'DateDemande_Cge'     => date('Y-m-d'),
            'Statut_Cge'          => $statutInitial,
            'id_Emp'              => $idEmpCible,
            'id_Emp_ValidDir'     => $idEmpValidDir,
            'DateDecisionDir_Cge' => $dateDecisionDir,
        ]);

        $lien = base_url('conge/show/' . $id);

        if ($idPfl == 3) {
            $this->notif->envoyerMultiple(
                $this->getChefIds(),
                'Nouvelle demande de conge',
                $demandeur['Nom_Emp'] . ' ' . $demandeur['Prenom_Emp']
                . ' a soumis une demande de conge du '
                . date('d/m/Y', strtotime($debut))
                . ' au ' . date('d/m/Y', strtotime($fin)) . '.',
                'conge', $lien, $idEmp
            );
        }

        if ($idPfl == 2) {
            $this->notif->envoyerMultiple(
                $this->getRHIds(),
                'Demande de conge - Chef de Direction',
                $demandeur['Nom_Emp'] . ' ' . $demandeur['Prenom_Emp']
                . ' (Chef de Direction) a soumis une demande de conge du '
                . date('d/m/Y', strtotime($debut))
                . ' au ' . date('d/m/Y', strtotime($fin)) . '.',
                'conge', $lien, $idEmp
            );
        }

        if ($idPfl == 1 && $idEmpCible == $idEmp) {
            $this->notif->envoyerMultiple(
                $this->getRHIds(),
                'Demande de conge RH a valider',
                $demandeur['Nom_Emp'] . ' ' . $demandeur['Prenom_Emp']
                . ' (RH) a soumis une demande de conge du '
                . date('d/m/Y', strtotime($debut))
                . ' au ' . date('d/m/Y', strtotime($fin))
                . '. En attente de validation finale.',
                'conge', $lien, $idEmp
            );
        }

        if ($idPfl == 1 && $idEmpCible != $idEmp) {
            $this->notif->envoyerMultiple(
                $this->getChefIds(),
                'Nouvelle demande de conge',
                $demandeur['Nom_Emp'] . ' ' . $demandeur['Prenom_Emp']
                . ' a soumis une demande de conge du '
                . date('d/m/Y', strtotime($debut))
                . ' au ' . date('d/m/Y', strtotime($fin)) . '.',
                'conge', $lien, $idEmp
            );
            $this->notif->envoyer(
                $idEmpCible,
                'Une demande de conge a ete creee pour vous',
                'Le RH a cree une demande de conge en votre nom du '
                . date('d/m/Y', strtotime($debut))
                . ' au ' . date('d/m/Y', strtotime($fin)) . '.',
                'conge', $lien, $idEmp
            );
        }

        $this->log->insert([
            'Action_Log'      => 'CREATE',
            'Module_Log'      => 'Conge',
            'Description_Log' => 'Nouvelle demande conge ID : ' . $id,
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => $idEmp,
        ]);

        return redirect()->to('conge')
                         ->with('success', 'Demande de conge soumise avec succes.');
    }

    // ── EDIT ──────────────────────────────────────────────────
    public function edit($id)
    {
        $idPfl = $this->idPfl();
        $idEmp = $this->idEmp();
        $conge = $this->model->find($id);

        if (!$conge) {
            return redirect()->to('conge')->with('error', 'Conge introuvable.');
        }

        if ($conge['id_Emp'] != $idEmp) {
            return redirect()->to('conge')->with('error', 'Acces refuse.');
        }

        if ($conge['Statut_Cge'] != 'en_attente') {
            return redirect()->to('conge/show/' . $id)
                             ->with('error', 'Impossible de modifier une demande deja traitee.');
        }

        $data['title']      = 'Modifier le Conge';
        $data['conge']      = $conge;
        $data['typesConge'] = (new TypeCongeModel())->findAll();
        $data['idPfl']      = $idPfl;

        return view('rh/conge/edit', $data);
    }

    // ── UPDATE ────────────────────────────────────────────────
    public function update($id)
    {
        $idEmp = $this->idEmp();
        $conge = $this->model->find($id);

        if (!$conge) {
            return redirect()->to('conge')->with('error', 'Conge introuvable.');
        }

        if ($conge['id_Emp'] != $idEmp) {
            return redirect()->to('conge')->with('error', 'Acces refuse.');
        }

        if ($conge['Statut_Cge'] != 'en_attente') {
            return redirect()->to('conge/show/' . $id)
                             ->with('error', 'Impossible de modifier une demande deja traitee.');
        }

        $debut = $this->request->getPost('DateDebut_Cge');
        $fin   = $this->request->getPost('DateFin_Cge');

        if ($fin < $debut) {
            return redirect()->back()->withInput()
                             ->with('error', 'La date de fin doit etre apres la date de debut.');
        }

        $this->model->update($id, [
            'id_Tcg'        => $this->request->getPost('id_Tcg'),
            'Libelle_Cge'   => $this->request->getPost('Libelle_Cge'),
            'DateDebut_Cge' => $debut,
            'DateFin_Cge'   => $fin,
        ]);

        $this->log->insert([
            'Action_Log'      => 'UPDATE',
            'Module_Log'      => 'Conge',
            'Description_Log' => 'Modification conge ID : ' . $id,
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => $idEmp,
        ]);

        return redirect()->to('conge/show/' . $id)
                         ->with('success', 'Conge modifie avec succes.');
    }

    // ── DELETE ────────────────────────────────────────────────
    // Route : POST conge/delete/(:num)
    public function delete($id)
    {
        $idPfl = $this->idPfl();
        $idEmp = $this->idEmp();
        $conge = $this->model->find($id);

        if (!$conge) {
            return redirect()->to('conge')->with('error', 'Conge introuvable.');
        }

        if ($idPfl != 1) {
            if ($conge['id_Emp'] != $idEmp) {
                return redirect()->to('conge')->with('error', 'Acces refuse.');
            }
            if ($conge['Statut_Cge'] != 'en_attente') {
                return redirect()->to('conge/show/' . $id)
                                 ->with('error', 'Impossible d\'annuler une demande deja traitee.');
            }
        }

        $this->model->delete($id);

        $this->log->insert([
            'Action_Log'      => 'DELETE',
            'Module_Log'      => 'Conge',
            'Description_Log' => 'Suppression conge ID : ' . $id,
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => $idEmp,
        ]);

        return redirect()->to('conge')
                         ->with('success', 'Demande de conge annulee.');
    }

    // ══════════════════════════════════════════════════════════
    // WORKFLOW CHEF — approuver / refuser
    // Routes : POST conge/approuver/(:num)  |  POST conge/refuser/(:num)
    // ══════════════════════════════════════════════════════════

    public function approuver($id)
    {
        if ($this->idPfl() != 2) {
            return redirect()->to('conge')->with('error', 'Acces refuse.');
        }

        $conge = $this->model->find($id);

        if (!$conge || $conge['Statut_Cge'] != 'en_attente') {
            return redirect()->to('conge')->with('error', 'Action impossible sur cette demande.');
        }

        if ($conge['id_Emp'] == $this->idEmp()) {
            return redirect()->to('conge')
                             ->with('error', 'Vous ne pouvez pas approuver votre propre demande.');
        }

        $commentaire = $this->request->getPost('commentaire');

        $this->model->update($id, [
            'Statut_Cge'          => 'approuve_chef',
            'DateDecisionDir_Cge' => date('Y-m-d H:i:s'),
            'CommentaireDir_Cge'  => $commentaire,
            'id_Emp_ValidDir'     => $this->idEmp(),
        ]);

        $employe = (new EmployeModel())->find($conge['id_Emp']);
        $lien    = base_url('conge/show/' . $id);

        $this->notif->envoyerMultiple(
            $this->getRHIds(),
            'Conge approuve par le Chef - a valider',
            'La demande de conge de ' . $employe['Nom_Emp'] . ' ' . $employe['Prenom_Emp']
            . ' a ete approuvee par le Chef de Direction et attend votre validation finale.',
            'conge', $lien, $this->idEmp()
        );

        $this->notif->envoyer(
            $conge['id_Emp'],
            'Votre conge est en cours de validation',
            'Votre demande de conge a ete approuvee par votre Chef de Direction '
            . 'et transmise au RH pour validation finale.',
            'conge', $lien, $this->idEmp()
        );

        $this->log->insert([
            'Action_Log'      => 'APPROVE_CHEF',
            'Module_Log'      => 'Conge',
            'Description_Log' => 'Approbation Chef conge ID : ' . $id,
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => $this->idEmp(),
        ]);

        return redirect()->to('conge/show/' . $id)
                         ->with('success', 'Conge approuve et transmis au RH pour validation finale.');
    }

    public function refuser($id)
    {
        if ($this->idPfl() != 2) {
            return redirect()->to('conge')->with('error', 'Acces refuse.');
        }

        $conge = $this->model->find($id);

        if (!$conge || $conge['Statut_Cge'] != 'en_attente') {
            return redirect()->to('conge')->with('error', 'Action impossible sur cette demande.');
        }

        if ($conge['id_Emp'] == $this->idEmp()) {
            return redirect()->to('conge')
                             ->with('error', 'Vous ne pouvez pas refuser votre propre demande.');
        }

        $commentaire = $this->request->getPost('commentaire');

        if (empty($commentaire)) {
            return redirect()->back()
                             ->with('error', 'Un motif de refus est obligatoire.');
        }

        $this->model->update($id, [
            'Statut_Cge'          => 'rejete_chef',
            'DateDecisionDir_Cge' => date('Y-m-d H:i:s'),
            'CommentaireDir_Cge'  => $commentaire,
            'id_Emp_ValidDir'     => $this->idEmp(),
        ]);

        $employe = (new EmployeModel())->find($conge['id_Emp']);
        $lien    = base_url('conge/show/' . $id);

        $this->notif->envoyer(
            $conge['id_Emp'],
            'Votre demande de conge a ete refusee',
            'Votre demande de conge a ete refusee par votre Chef de Direction. Motif : ' . $commentaire,
            'conge', $lien, $this->idEmp()
        );

        $this->notif->envoyerMultiple(
            $this->getRHIds(),
            'Conge refuse par le Chef',
            'La demande de conge de ' . $employe['Nom_Emp'] . ' ' . $employe['Prenom_Emp']
            . ' a ete refusee par le Chef de Direction. Motif : ' . $commentaire,
            'conge', $lien, $this->idEmp()
        );

        $this->log->insert([
            'Action_Log'      => 'REJECT_CHEF',
            'Module_Log'      => 'Conge',
            'Description_Log' => 'Refus Chef conge ID : ' . $id . ' — ' . $commentaire,
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => $this->idEmp(),
        ]);

        return redirect()->to('conge/show/' . $id)
                         ->with('success', 'Conge refuse. L\'employe et le RH ont ete notifies.');
    }

    // ══════════════════════════════════════════════════════════
    // WORKFLOW RH — valider / rejeter
    // Routes : POST conge/valider/(:num)  |  POST conge/rejeter/(:num)
    // ══════════════════════════════════════════════════════════

    public function valider($id)
    {
        if ($this->idPfl() != 1) {
            return redirect()->to('conge')->with('error', 'Acces refuse.');
        }

        $conge = $this->model->find($id);

        if (!$conge || $conge['Statut_Cge'] != 'approuve_chef') {
            return redirect()->to('conge')->with('error', 'Action impossible sur cette demande.');
        }

        $commentaire = $this->request->getPost('commentaire');

        $this->model->update($id, [
            'Statut_Cge'           => 'valide_rh',
            'DateValidationRH_Cge' => date('Y-m-d H:i:s'),
            'CommentaireRH_Cge'    => $commentaire,
            'id_Emp_ValidRH'       => $this->idEmp(),
        ]);

        // Deduction automatique du solde
        $soldeModel = new SoldeCongeModel();
        $solde = $soldeModel
            ->where('id_Emp', $conge['id_Emp'])
            ->where('Annee_Sld', date('Y', strtotime($conge['DateDebut_Cge'])))
            ->first();

        if ($solde) {
            $nbJours = (new \DateTime($conge['DateDebut_Cge']))
                ->diff(new \DateTime($conge['DateFin_Cge']))->days + 1;
            $soldeModel->update($solde['id_Sld'], [
                'NbJoursPris_Sld' => $solde['NbJoursPris_Sld'] + $nbJours,
            ]);
        }

        $lien = base_url('conge/show/' . $id);

        $this->notif->envoyer(
            $conge['id_Emp'],
            'Votre conge est valide !',
            'Votre demande de conge du '
            . date('d/m/Y', strtotime($conge['DateDebut_Cge']))
            . ' au ' . date('d/m/Y', strtotime($conge['DateFin_Cge']))
            . ' a ete validee definitivement par le RH.',
            'conge', $lien, $this->idEmp()
        );

        $this->log->insert([
            'Action_Log'      => 'VALIDATE_RH',
            'Module_Log'      => 'Conge',
            'Description_Log' => 'Validation finale RH conge ID : ' . $id,
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => $this->idEmp(),
        ]);

        return redirect()->to('conge/show/' . $id)
                         ->with('success', 'Conge valide definitivement. Le solde a ete mis a jour.');
    }

    public function rejeter($id)
    {
        if ($this->idPfl() != 1) {
            return redirect()->to('conge')->with('error', 'Acces refuse.');
        }

        $conge = $this->model->find($id);

        if (!$conge || $conge['Statut_Cge'] != 'approuve_chef') {
            return redirect()->to('conge')->with('error', 'Action impossible sur cette demande.');
        }

        $commentaire = $this->request->getPost('commentaire');

        if (empty($commentaire)) {
            return redirect()->back()
                             ->with('error', 'Un motif de rejet est obligatoire.');
        }

        $this->model->update($id, [
            'Statut_Cge'           => 'rejete_rh',
            'DateValidationRH_Cge' => date('Y-m-d H:i:s'),
            'CommentaireRH_Cge'    => $commentaire,
            'id_Emp_ValidRH'       => $this->idEmp(),
        ]);

        $lien = base_url('conge/show/' . $id);

        $this->notif->envoyer(
            $conge['id_Emp'],
            'Votre demande de conge a ete rejetee par le RH',
            'Votre demande de conge a ete rejetee par le RH malgre l\'approbation du Chef. Motif : ' . $commentaire,
            'conge', $lien, $this->idEmp()
        );

        $this->log->insert([
            'Action_Log'      => 'REJECT_RH',
            'Module_Log'      => 'Conge',
            'Description_Log' => 'Rejet RH conge ID : ' . $id . ' — ' . $commentaire,
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => $this->idEmp(),
        ]);

        return redirect()->to('conge/show/' . $id)
                         ->with('success', 'Demande rejetee. L\'employe a ete notifie.');
    }
}