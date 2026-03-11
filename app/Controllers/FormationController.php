<?php

namespace App\Controllers;

use App\Models\NotificationModel;
use App\Models\ActivityLogModel;
use App\Models\EmployeModel;

class FormationController extends BaseController
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

    // ── INDEX ─────────────────────────────────────────────────
    public function index()
    {
        $db    = \Config\Database::connect();
        $idPfl = $this->idPfl();
        $idEmp = $this->idEmp();

        // Toutes les formations du catalogue
        $formations = $db->table('formation')
            ->orderBy('DateDebut_Frm', 'DESC')
            ->get()->getResultArray();

        // Pour chaque formation, compter les inscrits validés
        foreach ($formations as &$f) {
            $f['nb_valides'] = $db->table('s_inscrire')
                ->where('id_Frm', $f['id_Frm'])
                ->where('Stt_Ins', 'valide')
                ->countAllResults();

            $f['nb_inscrits'] = $db->table('s_inscrire')
                ->where('id_Frm', $f['id_Frm'])
                ->whereIn('Stt_Ins', ['inscrit', 'valide'])
                ->countAllResults();

            // Mon inscription personnelle
            $f['mon_inscription'] = $db->table('s_inscrire')
                ->where('id_Frm', $f['id_Frm'])
                ->where('id_Emp', $idEmp)
                ->get()->getRowArray();
        }
        unset($f);

        $data['title']      = 'Formations';
        $data['formations'] = $formations;
        $data['idPfl']      = $idPfl;
        $data['idEmp']      = $idEmp;

        return view('rh/formation/index', $data);
    }

    // ── SHOW ──────────────────────────────────────────────────
    public function show($id)
    {
        $db    = \Config\Database::connect();
        $idPfl = $this->idPfl();
        $idEmp = $this->idEmp();

        $formation = $db->table('formation')
            ->where('id_Frm', $id)
            ->get()->getRowArray();

        if (!$formation) {
            return redirect()->to('formation')->with('error', 'Formation introuvable.');
        }

        // Participants avec détails
        $participants = $db->table('s_inscrire')
            ->select('s_inscrire.*, employe.Nom_Emp, employe.Prenom_Emp,
                      employe.Email_Emp, direction.Nom_Dir')
            ->join('employe',   'employe.id_Emp = s_inscrire.id_Emp',       'left')
            ->join('direction', 'direction.id_Dir = employe.id_Dir',        'left')
            ->where('s_inscrire.id_Frm', $id)
            ->orderBy('s_inscrire.Stt_Ins')
            ->get()->getResultArray();

        $nbValides  = count(array_filter($participants, fn($p) => $p['Stt_Ins'] === 'valide'));
        $nbInscrits = count(array_filter($participants, fn($p) => $p['Stt_Ins'] === 'inscrit'));
        $nbAnnules  = count(array_filter($participants, fn($p) => $p['Stt_Ins'] === 'annule'));

        // Mon inscription
        $monInscription = $db->table('s_inscrire')
            ->where('id_Frm', $id)
            ->where('id_Emp', $idEmp)
            ->get()->getRowArray();

        // Demande liée à cette formation (si existe)
        $demande = $db->table('demande_formation')
            ->where('id_Frm', $id)
            ->orderBy('DateDemande', 'DESC')
            ->get()->getRowArray();

        $data['title']          = 'Détail Formation';
        $data['formation']      = $formation;
        $data['participants']   = $participants;
        $data['nbValides']      = $nbValides;
        $data['nbInscrits']     = $nbInscrits;
        $data['nbAnnules']      = $nbAnnules;
        $data['monInscription'] = $monInscription;
        $data['demande']        = $demande;
        $data['idPfl']          = $idPfl;
        $data['idEmp']          = $idEmp;

        return view('rh/formation/show', $data);
    }

    // ── CREATE ────────────────────────────────────────────────
    public function create()
    {
        if ($this->idPfl() != 1) {
            return redirect()->to('formation')->with('error', 'Accès refusé.');
        }

        $db = \Config\Database::connect();

        // Nombre total d'employés par direction (pour l'option "Tous")
        $directions = $db->table('direction')
            ->select('direction.id_Dir, direction.Nom_Dir,
                      COUNT(employe.id_Emp) AS nb_employes')
            ->join('employe', 'employe.id_Dir = direction.id_Dir', 'left')
            ->groupBy('direction.id_Dir')
            ->orderBy('direction.Nom_Dir')
            ->get()->getResultArray();

        $data['title']      = 'Nouvelle formation';
        $data['directions'] = $directions;
        $data['idPfl']      = $this->idPfl();

        return view('rh/formation/create', $data);
    }

    // ── STORE ─────────────────────────────────────────────────
    public function store()
    {
        if ($this->idPfl() != 1) {
            return redirect()->to('formation')->with('error', 'Accès refusé.');
        }

        $rules = [
            'Description_Frm' => 'required|min_length[5]',
            'DateDebut_Frm'   => 'required',
            'DateFin_Frm'     => 'required',
            'Lieu_Frm'        => 'required',
            'Formateur_Frm'   => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()
                             ->with('errors', $this->validator->getErrors());
        }

        $debut = $this->request->getPost('DateDebut_Frm');
        $fin   = $this->request->getPost('DateFin_Frm');

        if ($fin < $debut) {
            return redirect()->back()->withInput()
                             ->with('error', 'La date de fin doit être après la date de début.');
        }

        // Capacité : "tous" ou valeur manuelle
        $optionCapacite = $this->request->getPost('option_capacite');
        $idDir          = (int)$this->request->getPost('id_Dir_capacite');

        if ($optionCapacite === 'tous' && $idDir) {
            $db       = \Config\Database::connect();
            $capacite = $db->table('employe')
                ->where('id_Dir', $idDir)
                ->countAllResults();
        } else {
            $capacite = (int)$this->request->getPost('Capacite_Frm');
        }

        if ($capacite <= 0) {
            return redirect()->back()->withInput()
                             ->with('error', 'La capacité doit être supérieure à 0.');
        }

        $db = \Config\Database::connect();
        $db->table('formation')->insert([
            'Description_Frm' => $this->request->getPost('Description_Frm'),
            'DateDebut_Frm'   => $debut,
            'DateFin_Frm'     => $fin,
            'Lieu_Frm'        => $this->request->getPost('Lieu_Frm'),
            'Formateur_Frm'   => $this->request->getPost('Formateur_Frm'),
            'Capacite_Frm'    => $capacite,
        ]);

        $newId = $db->insertID();

        $this->log->insert([
            'Action_Log'      => 'CREATE',
            'Module_Log'      => 'Formation',
            'Description_Log' => 'Création formation ID : ' . $newId . ' — ' . $this->request->getPost('Description_Frm'),
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => $this->idEmp(),
        ]);

        return redirect()->to('formation/show/' . $newId)
                         ->with('success', 'Formation créée avec succès.');
    }

    // ── EDIT ──────────────────────────────────────────────────
    public function edit($id)
    {
        if ($this->idPfl() != 1) {
            return redirect()->to('formation')->with('error', 'Accès refusé.');
        }

        $db        = \Config\Database::connect();
        $formation = $db->table('formation')->where('id_Frm', $id)->get()->getRowArray();

        if (!$formation) {
            return redirect()->to('formation')->with('error', 'Formation introuvable.');
        }

        $formation['nb_valides'] = $db->table('s_inscrire')
    ->where('id_Frm', $id)
    ->where('Stt_Ins', 'valide')
    ->countAllResults();

        $directions = $db->table('direction')
            ->select('direction.id_Dir, direction.Nom_Dir,
                      COUNT(employe.id_Emp) AS nb_employes')
            ->join('employe', 'employe.id_Dir = direction.id_Dir', 'left')
            ->groupBy('direction.id_Dir')
            ->orderBy('direction.Nom_Dir')
            ->get()->getResultArray();

        $data['title']      = 'Modifier la formation';
        $data['formation']  = $formation;
        $data['directions'] = $directions;
        $data['idPfl']      = $this->idPfl();

        return view('rh/formation/edit', $data);
    }

    // ── UPDATE ────────────────────────────────────────────────
    public function update($id)
    {
        if ($this->idPfl() != 1) {
            return redirect()->to('formation')->with('error', 'Accès refusé.');
        }

        $db        = \Config\Database::connect();
        $formation = $db->table('formation')->where('id_Frm', $id)->get()->getRowArray();

        if (!$formation) {
            return redirect()->to('formation')->with('error', 'Formation introuvable.');
        }

        $rules = [
            'Description_Frm' => 'required|min_length[5]',
            'DateDebut_Frm'   => 'required',
            'DateFin_Frm'     => 'required',
            'Lieu_Frm'        => 'required',
            'Formateur_Frm'   => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()
                             ->with('errors', $this->validator->getErrors());
        }

        $debut = $this->request->getPost('DateDebut_Frm');
        $fin   = $this->request->getPost('DateFin_Frm');

        if ($fin < $debut) {
            return redirect()->back()->withInput()
                             ->with('error', 'La date de fin doit être après la date de début.');
        }

        $optionCapacite = $this->request->getPost('option_capacite');
        $idDir          = (int)$this->request->getPost('id_Dir_capacite');

        if ($optionCapacite === 'tous' && $idDir) {
            $capacite = $db->table('employe')
                ->where('id_Dir', $idDir)
                ->countAllResults();
        } else {
            $capacite = (int)$this->request->getPost('Capacite_Frm');
        }

        if ($capacite <= 0) {
            return redirect()->back()->withInput()
                             ->with('error', 'La capacité doit être supérieure à 0.');
        }

        // Vérifier que la nouvelle capacité n'est pas inférieure aux inscrits validés
        $nbValides = $db->table('s_inscrire')
            ->where('id_Frm', $id)
            ->where('Stt_Ins', 'valide')
            ->countAllResults();

        if ($capacite < $nbValides) {
            return redirect()->back()->withInput()
                             ->with('error', 'La capacité ne peut pas être inférieure au nombre de participants déjà validés (' . $nbValides . ').');
        }

        $db->table('formation')->where('id_Frm', $id)->update([
            'Description_Frm' => $this->request->getPost('Description_Frm'),
            'DateDebut_Frm'   => $debut,
            'DateFin_Frm'     => $fin,
            'Lieu_Frm'        => $this->request->getPost('Lieu_Frm'),
            'Formateur_Frm'   => $this->request->getPost('Formateur_Frm'),
            'Capacite_Frm'    => $capacite,
        ]);

        $this->log->insert([
            'Action_Log'      => 'UPDATE',
            'Module_Log'      => 'Formation',
            'Description_Log' => 'Modification formation ID : ' . $id,
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => $this->idEmp(),
        ]);

        return redirect()->to('formation/show/' . $id)
                         ->with('success', 'Formation modifiée avec succès.');
    }

    // ── DELETE ────────────────────────────────────────────────
    public function delete($id)
    {
        if ($this->idPfl() != 1) {
            return redirect()->to('formation')->with('error', 'Accès refusé.');
        }

        $db        = \Config\Database::connect();
        $formation = $db->table('formation')->where('id_Frm', $id)->get()->getRowArray();

        if (!$formation) {
            return redirect()->to('formation')->with('error', 'Formation introuvable.');
        }

        // Empêcher la suppression si des participants sont validés
        $nbValides = $db->table('s_inscrire')
            ->where('id_Frm', $id)
            ->where('Stt_Ins', 'valide')
            ->countAllResults();

        if ($nbValides > 0) {
            return redirect()->to('formation')
                             ->with('error', 'Impossible de supprimer une formation avec des participants confirmés (' . $nbValides . ').');
        }

        // Supprimer les inscriptions liées
        $db->table('s_inscrire')->where('id_Frm', $id)->delete();

        // Supprimer la formation
        $db->table('formation')->where('id_Frm', $id)->delete();

        $this->log->insert([
            'Action_Log'      => 'DELETE',
            'Module_Log'      => 'Formation',
            'Description_Log' => 'Suppression formation : ' . $formation['Description_Frm'],
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => $this->idEmp(),
        ]);

        return redirect()->to('formation')
                         ->with('success', 'Formation supprimée.');
    }
}