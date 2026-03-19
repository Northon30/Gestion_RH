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

    private function profileView(string $page, array $data = []): string
    {
        $folder = match ($this->idPfl()) {
            1       => 'rh',
            2       => 'chef',
            3       => 'employe',
            default => 'employe',
        };
        return view("{$folder}/conge/{$page}", $data);
    }

    private function getRHIds(): array
    {
        $db = \Config\Database::connect();
        return array_column(
            $db->table('employe')->where('id_Pfl', 1)->get()->getResultArray(),
            'id_Emp'
        );
    }

    private function getChefsDirIds(int $idDir): array
    {
        $db = \Config\Database::connect();
        return array_column(
            $db->table('employe')
               ->where('id_Pfl', 2)
               ->where('id_Dir', $idDir)
               ->get()->getResultArray(),
            'id_Emp'
        );
    }

    // ── HELPER : peut modifier ? ───────────────────────────────
    // Aligné sur AbsenceController::peutModifier()
    private function peutModifier(array $conge): bool
    {
        $idEmp = $this->idEmp();
        $idPfl = $this->idPfl();

        if ($conge['id_Emp'] != $idEmp) {
            return false;
        }

        $statut = $conge['Statut_Cge'];

        // Chef pour lui-même : auto-approuvé mais RH pas encore validé → modifiable
        if ($idPfl == 2 &&
            $statut === 'approuve_chef' &&
            empty($conge['id_Emp_ValidRH'])) {
            return true;
        }

        // Tous les autres : modifiable seulement si encore en_attente
        return $statut === 'en_attente';
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

        $data = [
            'title'      => 'Congés',
            'conges'     => $conges,
            'idPfl'      => $idPfl,
            'idEmp'      => $idEmp,
            'directions' => $db->table('direction')->orderBy('Nom_Dir')->get()->getResultArray(),
            'typesConge' => $db->table('type_conge')->orderBy('Libelle_Tcg')->get()->getResultArray(),
        ];

        return $this->profileView('index', $data);
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
            return redirect()->to('conge')->with('error', 'Congé introuvable.');
        }

        if ($idPfl == 3 && $conge['id_Emp'] != $idEmp) {
            return redirect()->to('conge')->with('error', 'Accès refusé.');
        }

        if ($idPfl == 2) {
            $emp = (new EmployeModel())->find($idEmp);
            if ($conge['id_Emp'] != $idEmp && $conge['id_Dir'] != $emp['id_Dir']) {
                return redirect()->to('conge')->with('error', 'Accès refusé.');
            }
        }

        $solde = (new SoldeCongeModel())
            ->where('id_Emp', $conge['id_Emp'])
            ->where('Annee_Sld', date('Y', strtotime($conge['DateDebut_Cge'])))
            ->first();

        $data = [
            'title'        => 'Détail Congé',
            'conge'        => $conge,
            'solde'        => $solde,
            'peutModifier' => $this->peutModifier($conge),
            'idPfl'        => $idPfl,
            'idEmp'        => $idEmp,
        ];

        return $this->profileView('show', $data);
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

        $data = [
            'title'      => 'Nouvelle demande de congé',
            'typesConge' => (new TypeCongeModel())->findAll(),
            'solde'      => $solde,
            'idPfl'      => $idPfl,
        ];

        if ($idPfl == 1) {
            $data['employes'] = (new EmployeModel())->findAll();
        }

        return $this->profileView('create', $data);
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
                             ->with('error', 'La date de fin doit être après la date de début.');
        }

        $idEmpCible = ($idPfl == 1 && $this->request->getPost('id_Emp'))
            ? (int) $this->request->getPost('id_Emp')
            : $idEmp;

        $demandeur = (new EmployeModel())->find($idEmpCible);
        $idDir     = $demandeur['id_Dir'];

        // ── FIX : vérification du solde hors du bloc d'insertion ──
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
        // Si pas de solde enregistré, on laisse passer
        // (cas possible pour un nouveau employé sans solde initialisé)

        // ── Statut initial ──
        $statutInitial   = 'en_attente';
        $idEmpValidDir   = null;
        $dateDecisionDir = null;

        // Chef pour lui-même → saute son propre niveau de validation
        if ($idPfl == 2 && $idEmpCible == $idEmp) {
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

        $lien     = base_url('conge/show/' . $id);
        $nomEmp   = $demandeur['Nom_Emp'] . ' ' . $demandeur['Prenom_Emp'];
        $periode  = date('d/m/Y', strtotime($debut)) . ' au ' . date('d/m/Y', strtotime($fin));
        $chefsDir = $this->getChefsDirIds($idDir);

        // Cas 1 — Employé normal
        if ($idPfl == 3) {
            if (!empty($chefsDir)) {
                $this->notif->envoyerMultiple(
                    $chefsDir,
                    'Nouvelle demande de congé',
                    $nomEmp . ' a soumis une demande de congé du ' . $periode . '.',
                    'conge', $lien, $idEmp
                );
            }
            $this->notif->envoyerMultiple(
                $this->getRHIds(),
                'Nouvelle demande de congé',
                $nomEmp . ' a soumis une demande de congé du ' . $periode . '.',
                'conge', $lien, $idEmp
            );
        }

        // Cas 2 — RH pour lui-même
        if ($idPfl == 1 && $idEmpCible == $idEmp) {
            if (!empty($chefsDir)) {
                $this->notif->envoyerMultiple(
                    $chefsDir,
                    'Demande de congé RH à valider',
                    $nomEmp . ' (RH) a soumis une demande de congé du ' . $periode
                    . '. Votre validation est suffisante.',
                    'conge', $lien, $idEmp
                );
            }
        }

        // Cas 3 — Chef pour lui-même
        if ($idPfl == 2 && $idEmpCible == $idEmp) {
            $this->notif->envoyerMultiple(
                $this->getRHIds(),
                'Demande de congé Chef à valider',
                $nomEmp . ' (Chef de Direction) a soumis une demande de congé du ' . $periode
                . ' et attend votre validation.',
                'conge', $lien, $idEmp
            );
        }

        // Cas 4 — RH crée pour un autre employé
        if ($idPfl == 1 && $idEmpCible != $idEmp) {
            if (!empty($chefsDir)) {
                $this->notif->envoyerMultiple(
                    $chefsDir,
                    'Nouvelle demande de congé',
                    $nomEmp . ' a soumis une demande de congé du ' . $periode . '.',
                    'conge', $lien, $idEmp
                );
            }
            $this->notif->envoyerMultiple(
                $this->getRHIds(),
                'Nouvelle demande de congé',
                $nomEmp . ' a soumis une demande de congé du ' . $periode . '.',
                'conge', $lien, $idEmp
            );
            $this->notif->envoyer(
                $idEmpCible,
                'Une demande de congé a été créée pour vous',
                'Le RH a créé une demande de congé en votre nom du ' . $periode . '.',
                'conge', $lien, $idEmp
            );
        }

        $this->log->insert([
            'Action_Log'      => 'CREATE',
            'Module_Log'      => 'Conge',
            'Description_Log' => 'Nouvelle demande congé ID : ' . $id,
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => $idEmp,
        ]);

        return redirect()->to('conge/show/' . $id)
                         ->with('success', 'Demande de congé soumise avec succès.');
    }

    // ── EDIT ──────────────────────────────────────────────────
    public function edit($id)
    {
        $idPfl = $this->idPfl();
        $idEmp = $this->idEmp();
        $conge = $this->model->find($id);

        if (!$conge) {
            return redirect()->to('conge')->with('error', 'Congé introuvable.');
        }

        if ($conge['id_Emp'] != $idEmp) {
            return redirect()->to('conge')->with('error', 'Accès refusé.');
        }

        // ── FIX : utilise peutModifier() au lieu de en_attente uniquement ──
        if (!$this->peutModifier($conge)) {
            return redirect()->to('conge/show/' . $id)
                             ->with('error', 'Impossible de modifier cette demande.');
        }

        $data = [
            'title'      => 'Modifier le congé',
            'conge'      => $conge,
            'typesConge' => (new TypeCongeModel())->findAll(),
            'idPfl'      => $idPfl,
        ];

        return $this->profileView('edit', $data);
    }

    // ── UPDATE ────────────────────────────────────────────────
    public function update($id)
    {
        $idEmp = $this->idEmp();
        $conge = $this->model->find($id);

        if (!$conge || $conge['id_Emp'] != $idEmp) {
            return redirect()->to('conge')->with('error', 'Accès refusé.');
        }

        // ── FIX : utilise peutModifier() au lieu de en_attente uniquement ──
        if (!$this->peutModifier($conge)) {
            return redirect()->to('conge/show/' . $id)
                             ->with('error', 'Impossible de modifier cette demande.');
        }

        $debut = $this->request->getPost('DateDebut_Cge');
        $fin   = $this->request->getPost('DateFin_Cge');

        if ($fin < $debut) {
            return redirect()->back()->withInput()
                             ->with('error', 'La date de fin doit être après la date de début.');
        }

        $this->model->update($id, [
            'id_Tcg'        => $this->request->getPost('id_Tcg'),
            'Libelle_Cge'   => $this->request->getPost('Libelle_Cge'),
            'DateDebut_Cge' => $debut,
            'DateFin_Cge'   => $fin,
        ]);

        $lien      = base_url('conge/show/' . $id);
        $demandeur = (new EmployeModel())->find($idEmp);
        $nomEmp    = $demandeur['Nom_Emp'] . ' ' . $demandeur['Prenom_Emp'];
        $periode   = date('d/m/Y', strtotime($debut)) . ' au ' . date('d/m/Y', strtotime($fin));
        $chefsDir  = $this->getChefsDirIds($demandeur['id_Dir']);

        if (!empty($chefsDir)) {
            $this->notif->envoyerMultiple(
                $chefsDir,
                'Demande de congé modifiée',
                $nomEmp . ' a modifié sa demande de congé : ' . $periode . '.',
                'conge', $lien, $idEmp
            );
        }
        $this->notif->envoyerMultiple(
            $this->getRHIds(),
            'Demande de congé modifiée',
            $nomEmp . ' a modifié sa demande de congé : ' . $periode . '.',
            'conge', $lien, $idEmp
        );

        $this->log->insert([
            'Action_Log'      => 'UPDATE',
            'Module_Log'      => 'Conge',
            'Description_Log' => 'Modification congé ID : ' . $id,
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => $idEmp,
        ]);

        return redirect()->to('conge/show/' . $id)->with('success', 'Congé modifié avec succès.');
    }

    // ── DELETE ────────────────────────────────────────────────
    public function delete($id)
    {
        $idPfl = $this->idPfl();
        $idEmp = $this->idEmp();
        $conge = $this->model->find($id);

        if (!$conge) {
            return redirect()->to('conge')->with('error', 'Congé introuvable.');
        }

        if ($idPfl != 1) {
            if ($conge['id_Emp'] != $idEmp) {
                return redirect()->to('conge')->with('error', 'Accès refusé.');
            }
            if (!$this->peutModifier($conge)) {
                return redirect()->to('conge/show/' . $id)
                                 ->with('error', 'Impossible d\'annuler une demande déjà traitée.');
            }
        }

        $this->model->delete($id);

        $this->log->insert([
            'Action_Log'      => 'DELETE',
            'Module_Log'      => 'Conge',
            'Description_Log' => 'Suppression congé ID : ' . $id,
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => $idEmp,
        ]);

        return redirect()->to('conge')->with('success', 'Demande de congé annulée.');
    }

    // ══════════════════════════════════════════════════════════
    // WORKFLOW CHEF — approuver / refuser
    // ══════════════════════════════════════════════════════════

    public function approuver($id)
    {
        if ($this->idPfl() != 2) {
            return redirect()->to('conge')->with('error', 'Accès refusé.');
        }

        $conge = $this->model->find($id);

        if (!$conge || $conge['Statut_Cge'] != 'en_attente') {
            return redirect()->to('conge')->with('error', 'Action impossible sur cette demande.');
        }

        $chef    = (new EmployeModel())->find($this->idEmp());
        $employe = (new EmployeModel())->find($conge['id_Emp']);

        if ($conge['id_Emp'] == $this->idEmp()) {
            return redirect()->to('conge')
                             ->with('error', 'Vous ne pouvez pas approuver votre propre demande.');
        }

        if ($employe['id_Dir'] != $chef['id_Dir']) {
            return redirect()->to('conge')
                             ->with('error', 'Accès refusé. Cet employé n\'est pas dans votre direction.');
        }

        $lien = base_url('conge/show/' . $id);

        // ── Cas spécial : demandeur est RH → Chef = valideur final ──
        if ((int) $employe['id_Pfl'] === 1) {

            $this->model->update($id, [
                'Statut_Cge'           => 'valide_rh',
                'DateDecisionDir_Cge'  => date('Y-m-d H:i:s'),
                'DateValidationRH_Cge' => date('Y-m-d H:i:s'),
                'CommentaireDir_Cge'   => null,
                'id_Emp_ValidDir'      => $this->idEmp(),
            ]);

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

            $this->notif->envoyer(
                $conge['id_Emp'],
                'Votre congé est validé !',
                'Votre demande de congé du '
                . date('d/m/Y', strtotime($conge['DateDebut_Cge']))
                . ' au ' . date('d/m/Y', strtotime($conge['DateFin_Cge']))
                . ' a été validée par votre Chef de Direction.',
                'conge', $lien, $this->idEmp()
            );

            $this->log->insert([
                'Action_Log'      => 'VALIDATE_CHEF_FINAL',
                'Module_Log'      => 'Conge',
                'Description_Log' => 'Validation finale Chef (demandeur RH) congé ID : ' . $id,
                'IpAdresse_Log'   => $this->request->getIPAddress(),
                'DateHeure_Log'   => date('Y-m-d H:i:s'),
                'id_Emp'          => $this->idEmp(),
            ]);

            return redirect()->to('conge/show/' . $id)
                             ->with('success', 'Congé validé définitivement. Le solde a été mis à jour.');
        }

        // ── Cas normal : transmis au RH ──
        $this->model->update($id, [
            'Statut_Cge'          => 'approuve_chef',
            'DateDecisionDir_Cge' => date('Y-m-d H:i:s'),
            'CommentaireDir_Cge'  => null,
            'id_Emp_ValidDir'     => $this->idEmp(),
        ]);

        $this->notif->envoyerMultiple(
            $this->getRHIds(),
            'Congé approuvé par le Chef — à valider',
            'La demande de congé de ' . $employe['Nom_Emp'] . ' ' . $employe['Prenom_Emp']
            . ' a été approuvée par le Chef de Direction et attend votre validation finale.',
            'conge', $lien, $this->idEmp()
        );

        $this->notif->envoyer(
            $conge['id_Emp'],
            'Votre congé est en cours de validation',
            'Votre demande de congé a été approuvée par votre Chef de Direction '
            . 'et transmise au RH pour validation finale.',
            'conge', $lien, $this->idEmp()
        );

        $this->log->insert([
            'Action_Log'      => 'APPROVE_CHEF',
            'Module_Log'      => 'Conge',
            'Description_Log' => 'Approbation Chef congé ID : ' . $id,
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => $this->idEmp(),
        ]);

        return redirect()->to('conge/show/' . $id)
                         ->with('success', 'Congé approuvé et transmis au RH pour validation finale.');
    }

    public function refuser($id)
    {
        if ($this->idPfl() != 2) {
            return redirect()->to('conge')->with('error', 'Accès refusé.');
        }

        $conge = $this->model->find($id);

        if (!$conge || $conge['Statut_Cge'] != 'en_attente') {
            return redirect()->to('conge')->with('error', 'Action impossible sur cette demande.');
        }

        $chef    = (new EmployeModel())->find($this->idEmp());
        $employe = (new EmployeModel())->find($conge['id_Emp']);

        if ($conge['id_Emp'] == $this->idEmp()) {
            return redirect()->to('conge')
                             ->with('error', 'Vous ne pouvez pas refuser votre propre demande.');
        }

        if ($employe['id_Dir'] != $chef['id_Dir']) {
            return redirect()->to('conge')
                             ->with('error', 'Accès refusé. Cet employé n\'est pas dans votre direction.');
        }

        $commentaire = $this->request->getPost('commentaire');

        if (empty($commentaire)) {
            return redirect()->back()->with('error', 'Un motif de refus est obligatoire.');
        }

        $this->model->update($id, [
            'Statut_Cge'          => 'rejete_chef',
            'DateDecisionDir_Cge' => date('Y-m-d H:i:s'),
            'CommentaireDir_Cge'  => $commentaire,
            'id_Emp_ValidDir'     => $this->idEmp(),
        ]);

        $lien = base_url('conge/show/' . $id);

        $this->notif->envoyer(
            $conge['id_Emp'],
            'Votre demande de congé a été refusée',
            'Votre demande de congé a été refusée par votre Chef de Direction. Motif : ' . $commentaire,
            'conge', $lien, $this->idEmp()
        );

        if ((int) $employe['id_Pfl'] !== 1) {
            $this->notif->envoyerMultiple(
                $this->getRHIds(),
                'Congé refusé par le Chef',
                'La demande de congé de ' . $employe['Nom_Emp'] . ' ' . $employe['Prenom_Emp']
                . ' a été refusée par le Chef de Direction. Motif : ' . $commentaire,
                'conge', $lien, $this->idEmp()
            );
        }

        $this->log->insert([
            'Action_Log'      => 'REJECT_CHEF',
            'Module_Log'      => 'Conge',
            'Description_Log' => 'Refus Chef congé ID : ' . $id . ' — ' . $commentaire,
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => $this->idEmp(),
        ]);

        return redirect()->to('conge/show/' . $id)
                         ->with('success', 'Congé refusé. L\'employé a été notifié.');
    }

    // ══════════════════════════════════════════════════════════
    // WORKFLOW RH — valider / rejeter
    // ══════════════════════════════════════════════════════════

    public function valider($id)
    {
        if ($this->idPfl() != 1) {
            return redirect()->to('conge')->with('error', 'Accès refusé.');
        }

        $conge = $this->model->find($id);

        if (!$conge || $conge['Statut_Cge'] != 'approuve_chef') {
            return redirect()->to('conge')->with('error', 'Action impossible sur cette demande.');
        }

        if ($conge['id_Emp'] == $this->idEmp()) {
            return redirect()->to('conge')
                             ->with('error', 'Vous ne pouvez pas valider votre propre demande.');
        }

        $this->model->update($id, [
            'Statut_Cge'           => 'valide_rh',
            'DateValidationRH_Cge' => date('Y-m-d H:i:s'),
            'CommentaireRH_Cge'    => null,
            'id_Emp_ValidRH'       => $this->idEmp(),
        ]);

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

        $employe  = (new EmployeModel())->find($conge['id_Emp']);
        $lien     = base_url('conge/show/' . $id);
        $chefsDir = $this->getChefsDirIds($employe['id_Dir']);

        $this->notif->envoyer(
            $conge['id_Emp'],
            'Votre congé est validé !',
            'Votre demande de congé du '
            . date('d/m/Y', strtotime($conge['DateDebut_Cge']))
            . ' au ' . date('d/m/Y', strtotime($conge['DateFin_Cge']))
            . ' a été validée définitivement par le RH.',
            'conge', $lien, $this->idEmp()
        );

        if (!empty($chefsDir)) {
            $this->notif->envoyerMultiple(
                $chefsDir,
                'Congé validé par le RH',
                'La demande de congé de ' . $employe['Nom_Emp'] . ' ' . $employe['Prenom_Emp']
                . ' a été validée définitivement par le RH.',
                'conge', $lien, $this->idEmp()
            );
        }

        $this->log->insert([
            'Action_Log'      => 'VALIDATE_RH',
            'Module_Log'      => 'Conge',
            'Description_Log' => 'Validation finale RH congé ID : ' . $id,
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => $this->idEmp(),
        ]);

        return redirect()->to('conge/show/' . $id)
                         ->with('success', 'Congé validé définitivement. Le solde a été mis à jour.');
    }

    public function rejeter($id)
    {
        if ($this->idPfl() != 1) {
            return redirect()->to('conge')->with('error', 'Accès refusé.');
        }

        $conge = $this->model->find($id);

        if (!$conge || $conge['Statut_Cge'] != 'approuve_chef') {
            return redirect()->to('conge')->with('error', 'Action impossible sur cette demande.');
        }

        if ($conge['id_Emp'] == $this->idEmp()) {
            return redirect()->to('conge')
                             ->with('error', 'Vous ne pouvez pas rejeter votre propre demande.');
        }

        $commentaire = $this->request->getPost('commentaire');

        if (empty($commentaire)) {
            return redirect()->back()->with('error', 'Un motif de rejet est obligatoire.');
        }

        $this->model->update($id, [
            'Statut_Cge'           => 'rejete_rh',
            'DateValidationRH_Cge' => date('Y-m-d H:i:s'),
            'CommentaireRH_Cge'    => $commentaire,
            'id_Emp_ValidRH'       => $this->idEmp(),
        ]);

        $employe  = (new EmployeModel())->find($conge['id_Emp']);
        $lien     = base_url('conge/show/' . $id);
        $chefsDir = $this->getChefsDirIds($employe['id_Dir']);

        $this->notif->envoyer(
            $conge['id_Emp'],
            'Votre demande de congé a été rejetée par le RH',
            'Votre demande de congé a été rejetée par le RH malgré l\'approbation du Chef. Motif : ' . $commentaire,
            'conge', $lien, $this->idEmp()
        );

        if (!empty($chefsDir)) {
            $this->notif->envoyerMultiple(
                $chefsDir,
                'Congé rejeté par le RH',
                'La demande de congé de ' . $employe['Nom_Emp'] . ' ' . $employe['Prenom_Emp']
                . ' a été rejetée par le RH. Motif : ' . $commentaire,
                'conge', $lien, $this->idEmp()
            );
        }

        $this->log->insert([
            'Action_Log'      => 'REJECT_RH',
            'Module_Log'      => 'Conge',
            'Description_Log' => 'Rejet RH congé ID : ' . $id . ' — ' . $commentaire,
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => $this->idEmp(),
        ]);

        return redirect()->to('conge/show/' . $id)
                         ->with('success', 'Demande rejetée. L\'employé et le chef ont été notifiés.');
    }
}