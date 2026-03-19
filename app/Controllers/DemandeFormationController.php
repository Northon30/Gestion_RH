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

    private function idEmp(): int
    {
        return (int) session()->get('id_Emp');
    }

    private function idPfl(): int
    {
        return (int) session()->get('id_Pfl');
    }

    private function profileView(string $page, array $data = []): string
    {
        $folder = match ($this->idPfl()) {
            1       => 'rh',
            2       => 'chef',
            3       => 'employe',
            default => 'employe',
        };
        return view("{$folder}/formation/{$page}", $data);
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

    private function getDemande(int $id): ?array
    {
        $db = \Config\Database::connect();
        return $db->table('demande_formation')
            ->select('demande_formation.*,
                      employe.Nom_Emp, employe.Prenom_Emp,
                      employe.id_Dir, direction.Nom_Dir,
                      formation.Titre_Frm,
                      formation.Description_Frm,
                      formation.DateDebut_Frm,
                      formation.DateFin_Frm,
                      validRH.Nom_Emp    AS NomValidRH,
                      validRH.Prenom_Emp AS PrenomValidRH,
                      validDir.Nom_Emp    AS NomValidDir,
                      validDir.Prenom_Emp AS PrenomValidDir')
            ->join('employe',   'employe.id_Emp = demande_formation.id_Emp',              'left')
            ->join('direction', 'direction.id_Dir = employe.id_Dir',                     'left')
            ->join('formation', 'formation.id_Frm = demande_formation.id_Frm',           'left')
            ->join('employe validRH',  'validRH.id_Emp  = demande_formation.id_Emp_ValidRH',  'left')
            ->join('employe validDir', 'validDir.id_Emp = demande_formation.id_Emp_ValidDir', 'left')
            ->where('demande_formation.id_DFrm', $id)
            ->get()->getRowArray() ?: null;
    }

    // ── INDEX ─────────────────────────────────────────────────
    public function index()
    {
        $idPfl = $this->idPfl();
        $idEmp = $this->idEmp();

        if ($idEmp === 0) {
            return redirect()->to('formation')->with('error', 'Accès refusé.');
        }

        $db    = \Config\Database::connect();
        $query = $db->table('demande_formation')
            ->select('demande_formation.*, employe.Nom_Emp, employe.Prenom_Emp,
                      direction.Nom_Dir, formation.Titre_Frm,
                      formation.Description_Frm,
                      formation.DateDebut_Frm, formation.DateFin_Frm')
            ->join('employe',   'employe.id_Emp = demande_formation.id_Emp',   'left')
            ->join('direction', 'direction.id_Dir = employe.id_Dir',           'left')
            ->join('formation', 'formation.id_Frm = demande_formation.id_Frm', 'left');

        if ($idPfl == 3) {
            $query->where('demande_formation.id_Emp', $idEmp);
        } elseif ($idPfl == 2) {
            $chef = (new EmployeModel())->find($idEmp);
            if ($chef) $query->where('employe.id_Dir', $chef['id_Dir']);
        }

        $demandes   = $query->orderBy('demande_formation.DateDemande', 'DESC')->get()->getResultArray();
        $directions = $db->table('direction')->orderBy('Nom_Dir')->get()->getResultArray();

        return $this->profileView('demande_index', [
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
        $idPfl = $this->idPfl();
        $idEmp = $this->idEmp();

        if ($idEmp === 0) {
            return redirect()->to('formation')->with('error', 'Accès refusé.');
        }

        $demande = $this->getDemande((int) $id);
        if (!$demande) {
            return redirect()->to('demande-formation')->with('error', 'Demande introuvable.');
        }

        // Employé : uniquement ses propres demandes
        if ($idPfl == 3 && $demande['id_Emp'] != $idEmp) {
            return redirect()->to('demande-formation')->with('error', 'Accès refusé.');
        }

        // Chef : uniquement sa direction
        if ($idPfl == 2) {
            $chef = (new EmployeModel())->find($idEmp);
            if ($demande['id_Dir'] != $chef['id_Dir']) {
                return redirect()->to('demande-formation')->with('error', 'Accès refusé.');
            }
        }

        $db           = \Config\Database::connect();
        $participants = [];

        if (!empty($demande['id_Frm'])) {
            $participants = $db->table('s_inscrire')
                ->select('s_inscrire.*, employe.Nom_Emp, employe.Prenom_Emp,
                          employe.Email_Emp, direction.Nom_Dir')
                ->join('employe',   'employe.id_Emp = s_inscrire.id_Emp', 'left')
                ->join('direction', 'direction.id_Dir = employe.id_Dir',  'left')
                ->where('s_inscrire.id_Frm', $demande['id_Frm'])
                ->get()->getResultArray();
        }

        $employes_direction = [];
        if (in_array($idPfl, [1, 2]) &&
            $demande['Statut_DFrm'] === 'valide_rh' &&
            !empty($demande['id_Frm'])) {

            $inscritsIds = array_column($participants, 'id_Emp');
            $query = $db->table('employe')
                ->select('employe.id_Emp, employe.Nom_Emp, employe.Prenom_Emp,
                          employe.Email_Emp, employe.Disponibilite_Emp, direction.Nom_Dir')
                ->join('direction', 'direction.id_Dir = employe.id_Dir', 'left')
                ->where('employe.id_Dir', $demande['id_Dir'])
                ->where('employe.id_Pfl', 3)
                ->orderBy('employe.Nom_Emp');

            if (!empty($inscritsIds)) {
                $query->whereNotIn('employe.id_Emp', $inscritsIds);
            }
            $employes_direction = $query->get()->getResultArray();
        }

        $nbInscrits = count(array_filter($participants, fn($p) => $p['Stt_Ins'] === 'valide'));

        return $this->profileView('demande_show', [
            'title'              => 'Détail demande de formation',
            'demande'            => $demande,
            'participants'       => $participants,
            'employes_direction' => $employes_direction,
            'nbInscrits'         => $nbInscrits,
            'idPfl'              => $idPfl,
            'idEmp'              => $idEmp,
        ]);
    }

    // ── CREATE — Chef uniquement ──────────────────────────────
    public function create()
{
    if ($this->idPfl() != 2) {
        return redirect()->to('formation')->with('error', 'Accès refusé.');
    }

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

    return view('chef/formation/demande_create', [
        'title'      => 'Nouvelle demande de formation',
        'formations' => $formations,
        'idPfl'      => $this->idPfl(),
    ]);
}

    // ── STORE — Chef uniquement ───────────────────────────────
    public function store()
    {
        $idPfl = $this->idPfl();
        $idEmp = $this->idEmp();

        if ($idPfl != 2) {
            return redirect()->to('formation')->with('error', 'Accès refusé.');
        }

        $source = $this->request->getPost('_source');

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

        $idFrm = ($source === 'catalogue') ? (int) $this->request->getPost('id_Frm') : null;

        $db = \Config\Database::connect();
        $db->table('demande_formation')->insert([
            'DateDemande'       => date('Y-m-d'),
            'Motif'             => $this->request->getPost('Motif'),
            'Type_DFrm'         => $this->request->getPost('Type_DFrm'),
            'Statut_DFrm'       => 'en_attente',
            'id_Emp'            => $idEmp,
            'id_Frm'            => $idFrm,
            'Description_Libre' => $this->request->getPost('Description_Libre'),
            'DateDebut_Libre'   => $debut ?: null,
            'DateFin_Libre'     => $fin   ?: null,
            'Lieu_Libre'        => $this->request->getPost('Lieu_Libre'),
            'Formateur_Libre'   => $this->request->getPost('Formateur_Libre'),
            'id_Emp_ValidDir'   => $idEmp,
            'DateDecisionDir'   => date('Y-m-d H:i:s'),
        ]);

        $newId     = $db->insertID();
        $demandeur = (new EmployeModel())->find($idEmp);
        $lien      = base_url('demande-formation/show/' . $newId);

        $this->notif->envoyerMultiple(
            $this->getRHIds(),
            'Nouvelle demande de formation',
            $demandeur['Nom_Emp'] . ' ' . $demandeur['Prenom_Emp']
            . ' (Chef de Direction) a soumis une demande de formation à valider.',
            'formation', $lien, $idEmp
        );

        $this->log->insert([
            'Action_Log'      => 'CREATE',
            'Module_Log'      => 'DemandeFormation',
            'Description_Log' => 'Nouvelle demande formation ID : ' . $newId,
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => $idEmp,
        ]);

        return redirect()->to('demande-formation/show/' . $newId)
                         ->with('success', 'Demande soumise avec succès. En attente de validation RH.');
    }

    // ── EDIT — Chef uniquement ────────────────────────────────
    public function edit($id)
{
    $idEmp = $this->idEmp();
    if ($this->idPfl() != 2) {
        return redirect()->to('formation')->with('error', 'Accès refusé.');
    }

    $db      = \Config\Database::connect();
    $demande = $db->table('demande_formation')->where('id_DFrm', $id)->get()->getRowArray();

    if (!$demande || $demande['id_Emp'] != $idEmp) {
        return redirect()->to('demande-formation')->with('error', 'Accès refusé.');
    }

    if ($demande['Statut_DFrm'] !== 'en_attente') {
        return redirect()->to('demande-formation/show/' . $id)
                         ->with('error', 'Impossible de modifier une demande déjà traitée.');
    }

    // ── Ajouter les formations avec nb_valides ──
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

    return view('chef/formation/demande_edit', [
        'title'      => 'Modifier la demande',
        'demande'    => $demande,
        'formations' => $formations,
        'idPfl'      => $this->idPfl(),
    ]);
}

    // ── UPDATE — Chef uniquement ──────────────────────────────
    public function update($id)
    {
        $idEmp = $this->idEmp();

        if ($this->idPfl() != 2) {
            return redirect()->to('formation')->with('error', 'Accès refusé.');
        }

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

        // ── Notification de modification au RH ──
        $demandeur = (new EmployeModel())->find($idEmp);
        $lien      = base_url('demande-formation/show/' . $id);
        $this->notif->envoyerMultiple(
            $this->getRHIds(),
            'Demande de formation modifiée',
            $demandeur['Nom_Emp'] . ' ' . $demandeur['Prenom_Emp']
            . ' a modifié sa demande de formation.',
            'formation', $lien, $idEmp
        );

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

    // ── DELETE — Chef uniquement ──────────────────────────────
    public function delete($id)
    {
        $idEmp = $this->idEmp();

        if ($this->idPfl() != 2) {
            return redirect()->to('formation')->with('error', 'Accès refusé.');
        }

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

        return redirect()->to('demande-formation')->with('success', 'Demande supprimée.');
    }

    // ══════════════════════════════════════════════════════════
    // WORKFLOW RH — validerRH / rejeterRH
    // ══════════════════════════════════════════════════════════

    public function validerRH($id)
    {
        if ($this->idPfl() != 1) {
            return redirect()->to('demande-formation')->with('error', 'Accès refusé.');
        }

        $demande = $this->getDemande((int) $id);

        if (!$demande || $demande['Statut_DFrm'] !== 'en_attente') {
            return redirect()->to('demande-formation')->with('error', 'Action impossible.');
        }

        $db    = \Config\Database::connect();
        $idFrm = $demande['id_Frm'];

        // Formation libre → créer dans le catalogue
        if (!$idFrm) {
            $db->table('formation')->insert([
                'Titre_Frm'       => $demande['Description_Libre'] ?? 'Formation libre',
                'Description_Frm' => $demande['Description_Libre'],
                'DateDebut_Frm'   => $demande['DateDebut_Libre'],
                'DateFin_Frm'     => $demande['DateFin_Libre'] ?? $demande['DateDebut_Libre'],
                'Lieu_Frm'        => $demande['Lieu_Libre']      ?? 'À définir',
                'Formateur_Frm'   => $demande['Formateur_Libre'] ?? 'À définir',
                'Capacite_Frm'    => 0,
                'Statut_Frm'      => 'planifiee',
            ]);
            $idFrm = $db->insertID();
            $db->table('demande_formation')->where('id_DFrm', $id)->update(['id_Frm' => $idFrm]);
        }

        $db->table('demande_formation')->where('id_DFrm', $id)->update([
            'Statut_DFrm'    => 'valide_rh',
            'DateValidRH'    => date('Y-m-d H:i:s'),
            'CommentaireRH'  => null,
            'id_Emp_ValidRH' => $this->idEmp(),
        ]);

        $lien = base_url('demande-formation/show/' . $id);

        $this->notif->envoyer(
            $demande['id_Emp'],
            'Votre demande de formation a été validée',
            'Votre demande de formation a été validée par le RH. '
            . 'Vous pouvez maintenant sélectionner les participants.',
            'formation', $lien, $this->idEmp()
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
                         ->with('success', 'Demande validée. Le Chef peut maintenant sélectionner les participants.');
    }

    public function rejeterRH($id)
    {
        if ($this->idPfl() != 1) {
            return redirect()->to('demande-formation')->with('error', 'Accès refusé.');
        }

        $demande = $this->getDemande((int) $id);

        if (!$demande || $demande['Statut_DFrm'] !== 'en_attente') {
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

        $lien = base_url('demande-formation/show/' . $id);

        $this->notif->envoyer(
            $demande['id_Emp'],
            'Votre demande de formation a été rejetée',
            'Votre demande de formation a été rejetée par le RH. Motif : ' . $commentaire,
            'formation', $lien, $this->idEmp()
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
                         ->with('success', 'Demande rejetée. Le Chef a été notifié.');
    }

    // ══════════════════════════════════════════════════════════
    // SÉLECTION PARTICIPANTS — Chef ET RH
    // ══════════════════════════════════════════════════════════

    public function selectionner($id)
    {
        $idPfl = $this->idPfl();

        if (!in_array($idPfl, [1, 2])) {
            return redirect()->to('formation')->with('error', 'Accès refusé.');
        }

        $demande = $this->getDemande((int) $id);

        if (!$demande || $demande['Statut_DFrm'] !== 'valide_rh' || !$demande['id_Frm']) {
            return redirect()->to('demande-formation')->with('error', 'Action impossible.');
        }

        if ($idPfl == 2) {
            $chef = (new EmployeModel())->find($this->idEmp());
            if ($demande['id_Dir'] != $chef['id_Dir']) {
                return redirect()->to('demande-formation')
                                 ->with('error', 'Accès refusé. Cette demande ne concerne pas votre direction.');
            }
        }

        $db          = \Config\Database::connect();
        $idFrm       = (int) $demande['id_Frm'];
        $selectedIds = array_map('intval', (array) $this->request->getPost('employes'));

        if (empty($selectedIds)) {
            return redirect()->back()->with('error', 'Veuillez sélectionner au moins un participant.');
        }

        $db->table('formation')->where('id_Frm', $idFrm)
           ->update(['Capacite_Frm' => count($selectedIds)]);

        // Supprimer les anciennes invitations en attente
        $db->table('s_inscrire')
           ->where('id_Frm', $idFrm)
           ->where('Stt_Ins', 'invite')
           ->delete();

        $formation = $db->table('formation')->where('id_Frm', $idFrm)->get()->getRowArray();
        $lien      = base_url('formation/show/' . $idFrm);

        foreach ($selectedIds as $empId) {
            $existant = $db->table('s_inscrire')
                ->where('id_Emp', $empId)
                ->where('id_Frm', $idFrm)
                ->whereIn('Stt_Ins', ['valide', 'inscrit'])
                ->get()->getRowArray();

            if ($existant) continue;

            $db->table('s_inscrire')->insert([
                'Dte_Ins' => date('Y-m-d'),
                'Stt_Ins' => 'invite',
                'id_Emp'  => $empId,
                'id_Frm'  => $idFrm,
            ]);

            $this->notif->envoyer(
                $empId,
                'Invitation à une formation',
                'Vous avez été sélectionné pour participer à la formation : "'
                . ($formation['Titre_Frm'] ?? $formation['Description_Frm'] ?? '') . '". '
                . 'Veuillez accepter ou refuser.',
                'formation', $lien, $this->idEmp()
            );
        }

        $this->log->insert([
            'Action_Log'      => 'SELECT_PARTICIPANTS',
            'Module_Log'      => 'DemandeFormation',
            'Description_Log' => count($selectedIds) . ' participant(s) sélectionné(s) — formation ID : ' . $idFrm,
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => $this->idEmp(),
        ]);

        return redirect()->to('demande-formation/show/' . $id)
                         ->with('success', count($selectedIds) . ' participant(s) invité(s).');
    }

    // ══════════════════════════════════════════════════════════
    // RÉPONSE PARTICIPANT — Employé uniquement
    // ══════════════════════════════════════════════════════════

    public function accepter($idIns)
    {
        if ($this->idPfl() != 3) {
            return redirect()->to('formation')
                             ->with('error', 'Seul un employé peut accepter une invitation.');
        }

        $idEmp = $this->idEmp();
        $db    = \Config\Database::connect();

        $inscription = $db->table('s_inscrire')
            ->where('id_Ins', $idIns)
            ->where('id_Emp', $idEmp)
            ->get()->getRowArray();

        if (!$inscription || $inscription['Stt_Ins'] !== 'invite') {
            return redirect()->to('formation')->with('error', 'Action impossible.');
        }

        $formation  = $db->table('formation')->where('id_Frm', $inscription['id_Frm'])->get()->getRowArray();
        $nbInscrits = $db->table('s_inscrire')
            ->where('id_Frm', $inscription['id_Frm'])
            ->whereIn('Stt_Ins', ['inscrit', 'valide'])
            ->countAllResults();

        if ($formation['Capacite_Frm'] > 0 && $nbInscrits >= $formation['Capacite_Frm']) {
            $db->table('s_inscrire')->where('id_Ins', $idIns)->update(['Stt_Ins' => 'annule']);
            return redirect()->back()
                             ->with('error', 'La formation est complète. Votre invitation a été annulée.');
        }

        $db->table('s_inscrire')->where('id_Ins', $idIns)->update(['Stt_Ins' => 'inscrit']);

        $employe  = (new EmployeModel())->find($idEmp);
        $lien     = base_url('formation/show/' . $inscription['id_Frm']);
        $chefsDir = $this->getChefsDirIds($employe['id_Dir']);
        $titre    = $formation['Titre_Frm'] ?? $formation['Description_Frm'] ?? '';

        $this->notif->envoyerMultiple(
            $this->getRHIds(),
            'Invitation acceptée',
            $employe['Nom_Emp'] . ' ' . $employe['Prenom_Emp']
            . ' a accepté l\'invitation à la formation : "' . $titre . '".',
            'formation', $lien, $idEmp
        );

        if (!empty($chefsDir)) {
            $this->notif->envoyerMultiple(
                $chefsDir,
                'Invitation acceptée',
                $employe['Nom_Emp'] . ' ' . $employe['Prenom_Emp']
                . ' a accepté l\'invitation à la formation : "' . $titre . '".',
                'formation', $lien, $idEmp
            );
        }

        $this->log->insert([
            'Action_Log'      => 'ACCEPT_FORMATION',
            'Module_Log'      => 'DemandeFormation',
            'Description_Log' => 'Acceptation formation ID : ' . $inscription['id_Frm'],
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => $idEmp,
        ]);

        return redirect()->back()->with('success', 'Invitation acceptée. Vous êtes inscrit à la formation.');
    }

    public function refuser($idIns)
    {
        if ($this->idPfl() != 3) {
            return redirect()->to('formation')
                             ->with('error', 'Seul un employé peut refuser une invitation.');
        }

        $idEmp = $this->idEmp();
        $db    = \Config\Database::connect();

        $inscription = $db->table('s_inscrire')
            ->where('id_Ins', $idIns)
            ->where('id_Emp', $idEmp)
            ->get()->getRowArray();

        if (!$inscription || $inscription['Stt_Ins'] !== 'invite') {
            return redirect()->to('formation')->with('error', 'Action impossible.');
        }

        $db->table('s_inscrire')->where('id_Ins', $idIns)->update(['Stt_Ins' => 'annule']);

        $formation = $db->table('formation')->where('id_Frm', $inscription['id_Frm'])->get()->getRowArray();
        $employe   = (new EmployeModel())->find($idEmp);
        $lien      = base_url('formation/show/' . $inscription['id_Frm']);
        $chefsDir  = $this->getChefsDirIds($employe['id_Dir']);
        $titre     = $formation['Titre_Frm'] ?? $formation['Description_Frm'] ?? '';

        $this->notif->envoyerMultiple(
            $this->getRHIds(),
            'Invitation refusée',
            $employe['Nom_Emp'] . ' ' . $employe['Prenom_Emp']
            . ' a refusé l\'invitation à la formation : "' . $titre . '".',
            'formation', $lien, $idEmp
        );

        if (!empty($chefsDir)) {
            $this->notif->envoyerMultiple(
                $chefsDir,
                'Invitation refusée',
                $employe['Nom_Emp'] . ' ' . $employe['Prenom_Emp']
                . ' a refusé l\'invitation à la formation : "' . $titre . '".',
                'formation', $lien, $idEmp
            );
        }

        $this->log->insert([
            'Action_Log'      => 'REFUSE_FORMATION',
            'Module_Log'      => 'DemandeFormation',
            'Description_Log' => 'Refus formation ID : ' . $inscription['id_Frm'],
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => $idEmp,
        ]);

        return redirect()->back()->with('success', 'Invitation refusée. Le RH et le Chef ont été notifiés.');
    }
}