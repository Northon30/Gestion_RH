<?php

namespace App\Controllers;

use App\Models\NotificationModel;
use App\Models\ActivityLogModel;
use App\Models\EmployeModel;

class DemandeFormationController extends BaseController
{
    protected $notif;
    protected $log;

    public function __construct()
    {
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

    private function getDemande(int $id): ?array
    {
        $db = \Config\Database::connect();
        return $db->table('demande_formation')
            ->select('demande_formation.*,
                      employe.Nom_Emp, employe.Prenom_Emp,
                      employe.id_Dir, direction.Nom_Dir,
                      formation.Description_Frm,
                      formation.DateDebut_Frm,
                      formation.DateFin_Frm,
                      validRH.Nom_Emp    AS NomValidRH,
                      validRH.Prenom_Emp AS PrenomValidRH,
                      validDir.Nom_Emp    AS NomValidDir,
                      validDir.Prenom_Emp AS PrenomValidDir')
            ->join('employe',    'employe.id_Emp = demande_formation.id_Emp',             'left')
            ->join('direction',  'direction.id_Dir = employe.id_Dir',                    'left')
            ->join('formation',  'formation.id_Frm = demande_formation.id_Frm',          'left')
            ->join('employe validRH',  'validRH.id_Emp  = demande_formation.id_Emp_ValidRH',  'left')
            ->join('employe validDir', 'validDir.id_Emp = demande_formation.id_Emp_ValidDir', 'left')
            ->where('demande_formation.id_DFrm', $id)
            ->get()->getRowArray() ?: null;
    }

    // ── INDEX ─────────────────────────────────────────────────
    public function index()
    {
        $db    = \Config\Database::connect();
        $idEmp = $this->idEmp();
        $idPfl = $this->idPfl();
        $idDir = session()->get('id_Dir');

        $query = $db->table('demande_formation')
            ->select('demande_formation.*, employe.Nom_Emp, employe.Prenom_Emp,
                      direction.Nom_Dir, formation.Description_Frm,
                      formation.DateDebut_Frm, formation.DateFin_Frm')
            ->join('employe',   'employe.id_Emp = demande_formation.id_Emp',   'left')
            ->join('direction', 'direction.id_Dir = employe.id_Dir',           'left')
            ->join('formation', 'formation.id_Frm = demande_formation.id_Frm', 'left');

        if ($idPfl == 2) {
            $query->where('employe.id_Dir', $idDir);
        }

        $demandes   = $query->orderBy('demande_formation.DateDemande', 'DESC')->get()->getResultArray();
        $directions = $db->table('direction')->orderBy('Nom_Dir')->get()->getResultArray();

        return view('rh/formation/demande_index', [
            'title'      => 'Demandes de formation',
            'demandes'   => $demandes,
            'directions' => $directions,
            'idPfl'      => $idPfl,
            'idEmp'      => $idEmp,
        ]);
    }

    // ── SHOW ──────────────────────────────────────────────────
    public function show($id)
    {
        $idPfl   = $this->idPfl();
        $idEmp   = $this->idEmp();
        $demande = $this->getDemande((int)$id);

        if (!$demande) {
            return redirect()->to('demande-formation')->with('error', 'Demande introuvable.');
        }

        // Contrôle accès
        if ($idPfl == 3 && $demande['id_Emp'] != $idEmp) {
            return redirect()->to('demande-formation')->with('error', 'Accès refusé.');
        }

        if ($idPfl == 2) {
            $emp = (new EmployeModel())->find($idEmp);
            if ($demande['id_Emp'] != $idEmp && $demande['id_Dir'] != ($emp['id_Dir'] ?? null)) {
                return redirect()->to('demande-formation')->with('error', 'Accès refusé.');
            }
        }

        $db = \Config\Database::connect();

        // Participants inscrits (si formation liée)
        $participants = [];
        if (!empty($demande['id_Frm'])) {
            $participants = $db->table('s_inscrire')
                ->select('s_inscrire.*, employe.Nom_Emp, employe.Prenom_Emp,
                          employe.Email_Emp, direction.Nom_Dir')
                ->join('employe',   'employe.id_Emp = s_inscrire.id_Emp',  'left')
                ->join('direction', 'direction.id_Dir = employe.id_Dir',   'left')
                ->where('s_inscrire.id_Frm', $demande['id_Frm'])
                ->get()->getResultArray();
        }

        // Employés de la direction pour sélection RH
        // Visible uniquement si : RH + statut valide_rh + formation catalogue liée
        $employes_direction = [];
        if ($idPfl == 1 && $demande['Statut_DFrm'] === 'valide_rh' && !empty($demande['id_Frm'])) {
            $employes_direction = $db->table('employe')
                ->select('employe.id_Emp, employe.Nom_Emp, employe.Prenom_Emp,
                          employe.Email_Emp, employe.Disponibilite_Emp, direction.Nom_Dir')
                ->join('direction', 'direction.id_Dir = employe.id_Dir', 'left')
                ->where('employe.id_Dir', $demande['id_Dir'])
                ->orderBy('employe.Nom_Emp')
                ->get()->getResultArray();
        }

        $nbInscrits = count(array_filter($participants, fn($p) => $p['Stt_Ins'] === 'valide'));

        return view('rh/formation/demande_show', [
            'title'              => 'Détail demande de formation',
            'demande'            => $demande,
            'participants'       => $participants,
            'employes_direction' => $employes_direction,
            'nbInscrits'         => $nbInscrits,
            'idPfl'              => $idPfl,
            'idEmp'              => $idEmp,
        ]);
    }

    // ── CREATE ────────────────────────────────────────────────
    public function create()
    {
        $db = \Config\Database::connect();

        $formations = $db->table('formation')
            ->where('DateFin_Frm >=', date('Y-m-d'))
            ->orderBy('DateDebut_Frm')
            ->get()->getResultArray();

        foreach ($formations as &$f) {
            $f['nb_valides'] = $db->table('s_inscrire')
                ->where('id_Frm', $f['id_Frm'])
                ->where('Stt_Ins', 'valide')
                ->countAllResults();
        }
        unset($f);

        return view('rh/formation/demande_create', [
            'title'      => 'Nouvelle demande de formation',
            'formations' => $formations,
            'idPfl'      => $this->idPfl(),
        ]);
    }

    // ── STORE ─────────────────────────────────────────────────
    public function store()
    {
        $idPfl  = $this->idPfl();
        $idEmp  = $this->idEmp();
        $source = $this->request->getPost('_source'); // '_source' — nom dans la vue

        $rules = [
            'Type_DFrm' => 'required',
            'Motif'     => 'required|min_length[5]',
        ];

        if ($source === 'catalogue') {
            $rules['id_Frm'] = 'required';
        } else {
            $rules['Description_Libre'] = 'required|min_length[5]';
            $rules['DateDebut_Libre']   = 'required';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()
                             ->with('errors', $this->validator->getErrors());
        }

        $debut = $this->request->getPost('DateDebut_Libre');
        $fin   = $this->request->getPost('DateFin_Libre');

        if ($fin && $debut && $fin < $debut) {
            return redirect()->back()->withInput()
                             ->with('error', 'La date de fin doit être après la date de début.');
        }

        $idFrm           = ($source === 'catalogue') ? (int)$this->request->getPost('id_Frm') : null;
        $statutInitial   = ($idPfl == 2) ? 'approuve'           : 'en_attente';
        $idValidDir      = ($idPfl == 2) ? $idEmp               : null;
        $dateDecisionDir = ($idPfl == 2) ? date('Y-m-d H:i:s')  : null;

        $db = \Config\Database::connect();
        $db->table('demande_formation')->insert([
            'DateDemande'       => date('Y-m-d'),
            'Motif'             => $this->request->getPost('Motif'),
            'Type_DFrm'         => $this->request->getPost('Type_DFrm'),
            'Statut_DFrm'       => $statutInitial,
            'id_Emp'            => $idEmp,
            'id_Frm'            => $idFrm,
            'Description_Libre' => $this->request->getPost('Description_Libre'),
            'DateDebut_Libre'   => $debut  ?: null,
            'DateFin_Libre'     => $fin    ?: null,
            'Lieu_Libre'        => $this->request->getPost('Lieu_Libre'),
            'Formateur_Libre'   => $this->request->getPost('Formateur_Libre'),
            'id_Emp_ValidDir'   => $idValidDir,
            'DateDecisionDir'   => $dateDecisionDir,
        ]);

        $newId     = $db->insertID();
        $demandeur = (new EmployeModel())->find($idEmp);
        $lien      = base_url('demande-formation/show/' . $newId);

        if ($idPfl == 3) {
            $this->notif->envoyerMultiple(
                $this->getChefIds(),
                'Nouvelle demande de formation',
                $demandeur['Nom_Emp'] . ' ' . $demandeur['Prenom_Emp'] . ' a soumis une demande de formation.',
                'formation', $lien, $idEmp
            );
        }

        if ($idPfl == 2) {
            $this->notif->envoyerMultiple(
                $this->getRHIds(),
                'Demande de formation — Chef de Direction',
                $demandeur['Nom_Emp'] . ' ' . $demandeur['Prenom_Emp'] . ' (Chef) a soumis une demande à valider.',
                'formation', $lien, $idEmp
            );
        }

        $this->log->insert([
            'Action_Log'      => 'CREATE',
            'Module_Log'      => 'DemandeFormation',
            'Description_Log' => 'Nouvelle demande formation ID : ' . $newId,
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => $idEmp,
        ]);

        return redirect()->to('demande-formation/show/' . $newId)
                         ->with('success', 'Demande soumise avec succès.');
    }

    // ── EDIT ──────────────────────────────────────────────────
    public function edit($id)
    {
        $idPfl   = $this->idPfl();
        $idEmp   = $this->idEmp();
        $db      = \Config\Database::connect();
        $demande = $db->table('demande_formation')->where('id_DFrm', $id)->get()->getRowArray();

        if (!$demande) {
            return redirect()->to('demande-formation')->with('error', 'Demande introuvable.');
        }

        if ($demande['id_Emp'] != $idEmp) {
            return redirect()->to('demande-formation')->with('error', 'Accès refusé.');
        }

        if ($demande['Statut_DFrm'] !== 'en_attente') {
            return redirect()->to('demande-formation')
                             ->with('error', 'Impossible de modifier une demande déjà traitée.');
        }

        $formations = $db->table('formation')
            ->where('DateFin_Frm >=', date('Y-m-d'))
            ->orderBy('DateDebut_Frm')
            ->get()->getResultArray();

        foreach ($formations as &$f) {
            $f['nb_valides'] = $db->table('s_inscrire')
                ->where('id_Frm', $f['id_Frm'])
                ->where('Stt_Ins', 'valide')
                ->countAllResults();
        }
        unset($f);

        return view('rh/formation/demande_edit', [
            'title'      => 'Modifier la demande',
            'demande'    => $demande,
            'formations' => $formations,
            'idPfl'      => $idPfl,
        ]);
    }

    // ── UPDATE ────────────────────────────────────────────────
    public function update($id)
    {
        $idEmp   = $this->idEmp();
        $db      = \Config\Database::connect();
        $demande = $db->table('demande_formation')->where('id_DFrm', $id)->get()->getRowArray();

        if (!$demande || $demande['id_Emp'] != $idEmp || $demande['Statut_DFrm'] !== 'en_attente') {
            return redirect()->to('demande-formation')->with('error', 'Action impossible.');
        }

        $source = $this->request->getPost('_source');
        $debut  = $this->request->getPost('DateDebut_Libre');
        $fin    = $this->request->getPost('DateFin_Libre');

        if ($fin && $debut && $fin < $debut) {
            return redirect()->back()->withInput()
                             ->with('error', 'La date de fin doit être après la date de début.');
        }

        $idFrm = ($source === 'catalogue') ? ($this->request->getPost('id_Frm') ?: null) : null;

        $db->table('demande_formation')->where('id_DFrm', $id)->update([
            'Motif'             => $this->request->getPost('Motif'),
            'Type_DFrm'         => $this->request->getPost('Type_DFrm'),
            'id_Frm'            => $idFrm,
            'Description_Libre' => $this->request->getPost('Description_Libre'),
            'DateDebut_Libre'   => $debut ?: null,
            'DateFin_Libre'     => $fin   ?: null,
            'Lieu_Libre'        => $this->request->getPost('Lieu_Libre'),
            'Formateur_Libre'   => $this->request->getPost('Formateur_Libre'),
        ]);

        $this->log->insert([
            'Action_Log'      => 'UPDATE',
            'Module_Log'      => 'DemandeFormation',
            'Description_Log' => 'Modification demande formation ID : ' . $id,
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => $idEmp,
        ]);

        return redirect()->to('demande-formation/show/' . $id)
                         ->with('success', 'Demande modifiée avec succès.');
    }

    // ── DELETE ────────────────────────────────────────────────
    public function delete($id)
    {
        $idEmp   = $this->idEmp();
        $db      = \Config\Database::connect();
        $demande = $db->table('demande_formation')->where('id_DFrm', $id)->get()->getRowArray();

        if (!$demande || $demande['id_Emp'] != $idEmp || $demande['Statut_DFrm'] !== 'en_attente') {
            return redirect()->to('demande-formation')->with('error', 'Action impossible.');
        }

        $db->table('demande_formation')->where('id_DFrm', $id)->delete();

        $this->log->insert([
            'Action_Log'      => 'DELETE',
            'Module_Log'      => 'DemandeFormation',
            'Description_Log' => 'Suppression demande formation ID : ' . $id,
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => $idEmp,
        ]);

        return redirect()->to('demande-formation')
                         ->with('success', 'Demande supprimée.');
    }

    // ══════════════════════════════════════════════════════════
    // WORKFLOW CHEF — étape 1
    // ══════════════════════════════════════════════════════════

    public function approuver($id)
    {
        if ($this->idPfl() != 2) {
            return redirect()->to('demande-formation')->with('error', 'Accès refusé.');
        }

        $demande = $this->getDemande((int)$id);

        if (!$demande || $demande['Statut_DFrm'] !== 'en_attente') {
            return redirect()->to('demande-formation')->with('error', 'Action impossible.');
        }

        if ($demande['id_Emp'] == $this->idEmp()) {
            return redirect()->to('demande-formation')
                             ->with('error', 'Vous ne pouvez pas approuver votre propre demande.');
        }

        $db = \Config\Database::connect();
        $db->table('demande_formation')->where('id_DFrm', $id)->update([
            'Statut_DFrm'     => 'approuve',
            'DateDecisionDir' => date('Y-m-d H:i:s'),
            'CommentaireDir'  => $this->request->getPost('CommentaireDir'),
            'id_Emp_ValidDir' => $this->idEmp(),
        ]);

        $lien = base_url('demande-formation/show/' . $id);

        $this->notif->envoyerMultiple(
            $this->getRHIds(),
            'Demande de formation approuvée',
            'La demande de ' . $demande['Nom_Emp'] . ' ' . $demande['Prenom_Emp'] . ' a été approuvée.',
            'formation', $lien, $this->idEmp()
        );

        $this->notif->envoyer(
            $demande['id_Emp'],
            'Votre demande de formation a été approuvée',
            'Votre demande a été approuvée et transmise au RH.',
            'formation', $lien, $this->idEmp()
        );

        $this->log->insert([
            'Action_Log'      => 'APPROVE',
            'Module_Log'      => 'DemandeFormation',
            'Description_Log' => 'Approbation demande formation ID : ' . $id,
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => $this->idEmp(),
        ]);

        return redirect()->to('demande-formation/show/' . $id)
                         ->with('success', 'Demande approuvée et transmise au RH.');
    }

    public function rejeter($id)
    {
        if ($this->idPfl() != 2) {
            return redirect()->to('demande-formation')->with('error', 'Accès refusé.');
        }

        $demande = $this->getDemande((int)$id);

        if (!$demande || $demande['Statut_DFrm'] !== 'en_attente') {
            return redirect()->to('demande-formation')->with('error', 'Action impossible.');
        }

        if ($demande['id_Emp'] == $this->idEmp()) {
            return redirect()->to('demande-formation')
                             ->with('error', 'Vous ne pouvez pas rejeter votre propre demande.');
        }

        $commentaire = $this->request->getPost('CommentaireDir');
        if (empty($commentaire)) {
            return redirect()->back()->with('error', 'Un motif de refus est obligatoire.');
        }

        $db = \Config\Database::connect();
        $db->table('demande_formation')->where('id_DFrm', $id)->update([
            'Statut_DFrm'     => 'rejete',
            'DateDecisionDir' => date('Y-m-d H:i:s'),
            'CommentaireDir'  => $commentaire,
            'id_Emp_ValidDir' => $this->idEmp(),
        ]);

        $this->notif->envoyer(
            $demande['id_Emp'],
            'Votre demande de formation a été refusée',
            'Motif : ' . $commentaire,
            'formation', base_url('demande-formation/show/' . $id), $this->idEmp()
        );

        $this->log->insert([
            'Action_Log'      => 'REJECT',
            'Module_Log'      => 'DemandeFormation',
            'Description_Log' => 'Refus demande formation ID : ' . $id,
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => $this->idEmp(),
        ]);

        return redirect()->to('demande-formation/show/' . $id)
                         ->with('success', 'Demande refusée. Le demandeur a été notifié.');
    }

    // ══════════════════════════════════════════════════════════
    // WORKFLOW RH — étape 2
    // ══════════════════════════════════════════════════════════

    public function validerRH($id)
    {
        if ($this->idPfl() != 1) {
            return redirect()->to('demande-formation')->with('error', 'Accès refusé.');
        }

        $demande = $this->getDemande((int)$id);

        if (!$demande || $demande['Statut_DFrm'] !== 'approuve') {
            return redirect()->to('demande-formation')->with('error', 'Action impossible.');
        }

        $db    = \Config\Database::connect();
        $idFrm = $demande['id_Frm'];

        // Formation libre → créer dans le catalogue
        if (!$idFrm) {
            $db->table('formation')->insert([
                'Description_Frm' => $demande['Description_Libre'],
                'DateDebut_Frm'   => $demande['DateDebut_Libre'],
                'DateFin_Frm'     => $demande['DateFin_Libre'] ?? $demande['DateDebut_Libre'],
                'Lieu_Frm'        => $demande['Lieu_Libre']    ?? 'À définir',
                'Formateur_Frm'   => $demande['Formateur_Libre'] ?? 'À définir',
                'Capacite_Frm'    => 0,
            ]);
            $idFrm = $db->insertID();
            $db->table('demande_formation')->where('id_DFrm', $id)->update(['id_Frm' => $idFrm]);
        }

        $db->table('demande_formation')->where('id_DFrm', $id)->update([
            'Statut_DFrm'    => 'valide_rh',
            'DateValidRH'    => date('Y-m-d H:i:s'),
            'CommentaireRH'  => $this->request->getPost('CommentaireRH'),
            'id_Emp_ValidRH' => $this->idEmp(),
        ]);

        $this->notif->envoyer(
            $demande['id_Emp'],
            'Votre demande de formation a été validée',
            'Votre demande a été validée par le RH. Les participants seront bientôt sélectionnés.',
            'formation', base_url('demande-formation/show/' . $id), $this->idEmp()
        );

        $this->log->insert([
            'Action_Log'      => 'VALIDATE_RH',
            'Module_Log'      => 'DemandeFormation',
            'Description_Log' => 'Validation RH demande formation ID : ' . $id,
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => $this->idEmp(),
        ]);

        return redirect()->to('demande-formation/show/' . $id)
                         ->with('success', 'Demande validée. Vous pouvez maintenant sélectionner les participants.');
    }

    public function rejeterRH($id)
    {
        if ($this->idPfl() != 1) {
            return redirect()->to('demande-formation')->with('error', 'Accès refusé.');
        }

        $demande = $this->getDemande((int)$id);

        if (!$demande || $demande['Statut_DFrm'] !== 'approuve') {
            return redirect()->to('demande-formation')->with('error', 'Action impossible.');
        }

        $commentaire = $this->request->getPost('CommentaireRH');
        if (empty($commentaire)) {
            return redirect()->back()->with('error', 'Un motif de rejet est obligatoire.');
        }

        $db = \Config\Database::connect();
        $db->table('demande_formation')->where('id_DFrm', $id)->update([
            'Statut_DFrm'    => 'rejete_rh',
            'DateValidRH'    => date('Y-m-d H:i:s'),
            'CommentaireRH'  => $commentaire,
            'id_Emp_ValidRH' => $this->idEmp(),
        ]);

        $this->notif->envoyer(
            $demande['id_Emp'],
            'Votre demande de formation a été rejetée',
            'Motif : ' . $commentaire,
            'formation', base_url('demande-formation/show/' . $id), $this->idEmp()
        );

        $this->log->insert([
            'Action_Log'      => 'REJECT_RH',
            'Module_Log'      => 'DemandeFormation',
            'Description_Log' => 'Rejet RH demande formation ID : ' . $id,
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => $this->idEmp(),
        ]);

        return redirect()->to('demande-formation/show/' . $id)
                         ->with('success', 'Demande rejetée. Le demandeur a été notifié.');
    }

    // ══════════════════════════════════════════════════════════
    // SÉLECTION PARTICIPANTS (RH)
    // ══════════════════════════════════════════════════════════

    public function selectionner($id)
    {
        if ($this->idPfl() != 1) {
            return redirect()->to('demande-formation')->with('error', 'Accès refusé.');
        }

        $demande = $this->getDemande((int)$id);

        if (!$demande || $demande['Statut_DFrm'] !== 'valide_rh' || !$demande['id_Frm']) {
            return redirect()->to('demande-formation')->with('error', 'Action impossible.');
        }

        $db          = \Config\Database::connect();
        $idFrm       = (int)$demande['id_Frm'];
        $selectedIds = array_map('intval', (array)$this->request->getPost('employes'));

        if (empty($selectedIds)) {
            return redirect()->back()->with('error', 'Veuillez sélectionner au moins un participant.');
        }

        // Mettre à jour la capacité
        $capacite = count($selectedIds);
        $db->table('formation')->where('id_Frm', $idFrm)->update(['Capacite_Frm' => $capacite]);

        // Supprimer les anciennes inscriptions en attente
        $db->table('s_inscrire')->where('id_Frm', $idFrm)->where('Stt_Ins', 'inscrit')->delete();

        $formation = $db->table('formation')->where('id_Frm', $idFrm)->get()->getRowArray();
        $lien      = base_url('demande-formation/show/' . $id);

        foreach ($selectedIds as $empId) {
            // Ne pas réinscrire quelqu'un déjà validé
            $existant = $db->table('s_inscrire')
                ->where('id_Emp', $empId)->where('id_Frm', $idFrm)->where('Stt_Ins', 'valide')
                ->get()->getRowArray();

            if ($existant) continue;

            $db->table('s_inscrire')->insert([
                'Dte_Ins' => date('Y-m-d'),
                'Stt_Ins' => 'inscrit',
                'id_Emp'  => $empId,
                'id_Frm'  => $idFrm,
            ]);

            $this->notif->envoyer(
                $empId,
                'Invitation à une formation',
                'Vous avez été sélectionné pour : "' . ($formation['Description_Frm'] ?? '') . '".',
                'formation', $lien, $this->idEmp()
            );
        }

        $this->log->insert([
            'Action_Log'      => 'SELECT_PARTICIPANTS',
            'Module_Log'      => 'DemandeFormation',
            'Description_Log' => $capacite . ' participant(s) — formation ID : ' . $idFrm,
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => $this->idEmp(),
        ]);

        return redirect()->to('demande-formation/show/' . $id)
                         ->with('success', $capacite . ' participant(s) notifié(s).');
    }

    // ══════════════════════════════════════════════════════════
    // RÉPONSE PARTICIPANT
    // ══════════════════════════════════════════════════════════

    public function accepter($idIns)
    {
        $idEmp = $this->idEmp();
        $db    = \Config\Database::connect();

        $inscription = $db->table('s_inscrire')
            ->where('id_Ins', $idIns)->where('id_Emp', $idEmp)
            ->get()->getRowArray();

        if (!$inscription || $inscription['Stt_Ins'] !== 'inscrit') {
            return redirect()->to('demande-formation')->with('error', 'Action impossible.');
        }

        $formation = $db->table('formation')->where('id_Frm', $inscription['id_Frm'])->get()->getRowArray();
        $nbValides = $db->table('s_inscrire')
            ->where('id_Frm', $inscription['id_Frm'])->where('Stt_Ins', 'valide')
            ->countAllResults();

        if ($nbValides >= $formation['Capacite_Frm']) {
            $db->table('s_inscrire')->where('id_Ins', $idIns)->update(['Stt_Ins' => 'annule']);
            return redirect()->back()->with('error', 'La formation est complète. Votre inscription a été annulée.');
        }

        $db->table('s_inscrire')->where('id_Ins', $idIns)->update(['Stt_Ins' => 'valide']);
        $nbValides++;

        if ($nbValides >= $formation['Capacite_Frm']) {
            $autresInscrits = $db->table('s_inscrire')
                ->select('id_Emp')->where('id_Frm', $inscription['id_Frm'])
                ->where('Stt_Ins', 'inscrit')->where('id_Emp !=', $idEmp)
                ->get()->getResultArray();

            $lienF = base_url('formation/show/' . $inscription['id_Frm']);
            foreach ($autresInscrits as $autre) {
                $db->table('s_inscrire')
                   ->where('id_Frm', $inscription['id_Frm'])
                   ->where('id_Emp', $autre['id_Emp'])->where('Stt_Ins', 'inscrit')
                   ->update(['Stt_Ins' => 'annule']);
                $this->notif->envoyer(
                    $autre['id_Emp'], 'Formation complète',
                    '"' . $formation['Description_Frm'] . '" est maintenant complète.',
                    'formation', $lienF, $idEmp
                );
            }
        }

        $employe = (new EmployeModel())->find($idEmp);
        $this->notif->envoyerMultiple(
            $this->getRHIds(), 'Participation confirmée',
            $employe['Nom_Emp'] . ' ' . $employe['Prenom_Emp'] . ' a confirmé sa participation à "'
            . $formation['Description_Frm'] . '".',
            'formation', base_url('formation/show/' . $inscription['id_Frm']), $idEmp
        );

        $this->log->insert([
            'Action_Log'      => 'ACCEPT_FORMATION',
            'Module_Log'      => 'DemandeFormation',
            'Description_Log' => 'Acceptation formation ID : ' . $inscription['id_Frm'],
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => $idEmp,
        ]);

        return redirect()->back()->with('success', 'Participation confirmée.');
    }

    public function refuser($idIns)
    {
        $idEmp = $this->idEmp();
        $db    = \Config\Database::connect();

        $inscription = $db->table('s_inscrire')
            ->where('id_Ins', $idIns)->where('id_Emp', $idEmp)
            ->get()->getRowArray();

        if (!$inscription || $inscription['Stt_Ins'] !== 'inscrit') {
            return redirect()->to('demande-formation')->with('error', 'Action impossible.');
        }

        $db->table('s_inscrire')->where('id_Ins', $idIns)->update(['Stt_Ins' => 'annule']);

        $formation = $db->table('formation')->where('id_Frm', $inscription['id_Frm'])->get()->getRowArray();
        $employe   = (new EmployeModel())->find($idEmp);

        $this->notif->envoyerMultiple(
            $this->getRHIds(), 'Participation refusée',
            $employe['Nom_Emp'] . ' ' . $employe['Prenom_Emp'] . ' a refusé "' . $formation['Description_Frm'] . '".',
            'formation', base_url('formation/show/' . $inscription['id_Frm']), $idEmp
        );

        $this->log->insert([
            'Action_Log'      => 'REFUSE_FORMATION',
            'Module_Log'      => 'DemandeFormation',
            'Description_Log' => 'Refus formation ID : ' . $inscription['id_Frm'],
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => $idEmp,
        ]);

        return redirect()->back()->with('success', 'Participation refusée. Le RH a été notifié.');
    }
}