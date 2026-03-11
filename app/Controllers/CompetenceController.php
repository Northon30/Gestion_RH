<?php

namespace App\Controllers;

use App\Models\NotificationModel;
use App\Models\ActivityLogModel;

class CompetenceController extends BaseController
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

    // ── INDEX ─────────────────────────────────────────────────
    public function index()
    {
        $db    = \Config\Database::connect();
        $idPfl = $this->idPfl();
        $idDir = session()->get('id_Dir');

        // ── Référentiel des compétences avec stats ──
        $competences = $db->table('competence')
            ->select('competence.id_Cmp, competence.Libelle_Cmp,
                      COUNT(DISTINCT obtenir.id_Emp) AS nb_employes,
                      SUM(CASE WHEN obtenir.Niveau_Obt = "debutant"      THEN 1 ELSE 0 END) AS nb_debutant,
                      SUM(CASE WHEN obtenir.Niveau_Obt = "intermediaire" THEN 1 ELSE 0 END) AS nb_intermediaire,
                      SUM(CASE WHEN obtenir.Niveau_Obt = "avance"        THEN 1 ELSE 0 END) AS nb_avance')
            ->join('obtenir', 'obtenir.id_Cmp = competence.id_Cmp', 'left')
            ->groupBy('competence.id_Cmp')
            ->orderBy('competence.Libelle_Cmp')
            ->get()->getResultArray();

        // ── Tous les résultats chargés — filtrage 100% côté JS, aucun rechargement ──
        $query = $db->table('obtenir')
            ->select('obtenir.id_Obt, obtenir.Niveau_Obt, obtenir.Dte_Obt,
                      employe.id_Emp, employe.Nom_Emp, employe.Prenom_Emp,
                      employe.Email_Emp, employe.Disponibilite_Emp,
                      direction.id_Dir, direction.Nom_Dir,
                      competence.id_Cmp, competence.Libelle_Cmp,
                      grade.Libelle_Grd')
            ->join('employe',    'employe.id_Emp = obtenir.id_Emp',    'left')
            ->join('direction',  'direction.id_Dir = employe.id_Dir',  'left')
            ->join('competence', 'competence.id_Cmp = obtenir.id_Cmp', 'left')
            ->join('grade',      'grade.id_Grd = employe.id_Grd',      'left');

        // Chef → uniquement sa direction
        if ($idPfl == 2) {
            $query->where('employe.id_Dir', $idDir);
        }

        $resultats = $query->orderBy('employe.Nom_Emp')->get()->getResultArray();

        // ── Données pour les selects de filtres ──
        $directions = $db->table('direction')->orderBy('Nom_Dir')->get()->getResultArray();

        // ── Stats globales ──
        $totalCompetences  = count($competences);
        $totalAttributions = $db->table('obtenir')->countAllResults();
        $totalDebutant     = $db->table('obtenir')->where('Niveau_Obt', 'debutant')->countAllResults();
        $totalInter        = $db->table('obtenir')->where('Niveau_Obt', 'intermediaire')->countAllResults();
        $totalAvance       = $db->table('obtenir')->where('Niveau_Obt', 'avance')->countAllResults();

        return view('rh/competence/index', [
            'title'             => 'Référentiel des compétences',
            'competences'       => $competences,
            'resultats'         => $resultats,
            'directions'        => $directions,
            'totalCompetences'  => $totalCompetences,
            'totalAttributions' => $totalAttributions,
            'totalDebutant'     => $totalDebutant,
            'totalInter'        => $totalInter,
            'totalAvance'       => $totalAvance,
            'idPfl'             => $idPfl,
            'idEmp'             => $this->idEmp(),
        ]);
    }

    // ── SHOW ──────────────────────────────────────────────────
    public function show($id)
    {
        $db    = \Config\Database::connect();
        $idPfl = $this->idPfl();
        $idDir = session()->get('id_Dir');

        $competence = $db->table('competence')->where('id_Cmp', $id)->get()->getRowArray();

        if (!$competence) {
            return redirect()->to('competence')->with('error', 'Compétence introuvable.');
        }

        $filtreNiveau    = $this->request->getGet('niveau');
        $filtreIdDir     = $this->request->getGet('id_Dir');
        $filtreRecherche = trim($this->request->getGet('recherche') ?? '');
        $filtreDateFrom  = $this->request->getGet('date_from');
        $filtreDateTo    = $this->request->getGet('date_to');

        $query = $db->table('obtenir')
            ->select('obtenir.id_Obt, obtenir.Niveau_Obt, obtenir.Dte_Obt,
                      employe.id_Emp, employe.Nom_Emp, employe.Prenom_Emp,
                      employe.Email_Emp, employe.Disponibilite_Emp,
                      direction.id_Dir, direction.Nom_Dir,
                      grade.Libelle_Grd')
            ->join('employe',   'employe.id_Emp = obtenir.id_Emp',   'left')
            ->join('direction', 'direction.id_Dir = employe.id_Dir', 'left')
            ->join('grade',     'grade.id_Grd = employe.id_Grd',     'left')
            ->where('obtenir.id_Cmp', (int)$id);

        if ($filtreNiveau)   $query->where('obtenir.Niveau_Obt', $filtreNiveau);
        if ($filtreIdDir)    $query->where('employe.id_Dir', (int)$filtreIdDir);
        if ($filtreDateFrom) $query->where('obtenir.Dte_Obt >=', $filtreDateFrom);
        if ($filtreDateTo)   $query->where('obtenir.Dte_Obt <=', $filtreDateTo);

        if ($filtreRecherche) {
            $query->groupStart()
                  ->like('employe.Nom_Emp',     $filtreRecherche)
                  ->orLike('employe.Prenom_Emp', $filtreRecherche)
                  ->groupEnd();
        }

        if ($idPfl == 2) {
            $query->where('employe.id_Dir', $idDir);
        }

        $employes = $query->orderBy('obtenir.Niveau_Obt')->orderBy('employe.Nom_Emp')->get()->getResultArray();

        $nbDebutant = count(array_filter($employes, fn($e) => $e['Niveau_Obt'] === 'debutant'));
        $nbInter    = count(array_filter($employes, fn($e) => $e['Niveau_Obt'] === 'intermediaire'));
        $nbAvance   = count(array_filter($employes, fn($e) => $e['Niveau_Obt'] === 'avance'));

        $directions = $db->table('direction')->orderBy('Nom_Dir')->get()->getResultArray();

        $dejaCmp  = array_column($employes, 'id_Emp');
        $empQuery = $db->table('employe')
            ->select('employe.id_Emp, employe.Nom_Emp, employe.Prenom_Emp, direction.Nom_Dir')
            ->join('direction', 'direction.id_Dir = employe.id_Dir', 'left')
            ->orderBy('employe.Nom_Emp');

        if ($idPfl == 2) {
            $empQuery->where('employe.id_Dir', $idDir);
        }

        if (!empty($dejaCmp)) {
            $empQuery->whereNotIn('employe.id_Emp', $dejaCmp);
        }

        $employesSans = $empQuery->get()->getResultArray();

        return view('rh/competence/show', [
            'title'           => 'Compétence : ' . $competence['Libelle_Cmp'],
            'competence'      => $competence,
            'employes'        => $employes,
            'employesSans'    => $employesSans,
            'nbDebutant'      => $nbDebutant,
            'nbInter'         => $nbInter,
            'nbAvance'        => $nbAvance,
            'directions'      => $directions,
            'filtreNiveau'    => $filtreNiveau,
            'filtreIdDir'     => $filtreIdDir,
            'filtreRecherche' => $filtreRecherche,
            'filtreDateFrom'  => $filtreDateFrom,
            'filtreDateTo'    => $filtreDateTo,
            'idPfl'           => $idPfl,
            'idEmp'           => $this->idEmp(),
        ]);
    }

    // ── CREATE ────────────────────────────────────────────────
    public function create()
    {
        if ($this->idPfl() != 1) {
            return redirect()->to('competence')->with('error', 'Accès refusé.');
        }

        return view('rh/competence/create', [
            'title' => 'Nouvelle compétence',
            'idPfl' => $this->idPfl(),
        ]);
    }

    // ── STORE ─────────────────────────────────────────────────
    public function store()
    {
        if ($this->idPfl() != 1) {
            return redirect()->to('competence')->with('error', 'Accès refusé.');
        }

        if (!$this->validate([
            'Libelle_Cmp' => 'required|min_length[2]|max_length[150]|is_unique[competence.Libelle_Cmp]',
        ])) {
            return redirect()->back()->withInput()
                             ->with('errors', $this->validator->getErrors());
        }

        $db = \Config\Database::connect();
        $db->table('competence')->insert([
            'Libelle_Cmp' => ucfirst(trim($this->request->getPost('Libelle_Cmp'))),
        ]);

        $newId = $db->insertID();

        $this->log->insert([
            'Action_Log'      => 'CREATE',
            'Module_Log'      => 'Competence',
            'Description_Log' => 'Création compétence : ' . $this->request->getPost('Libelle_Cmp'),
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => $this->idEmp(),
        ]);

        return redirect()->to('competence/show/' . $newId)->with('success', 'Compétence créée avec succès.');
    }

    // ── EDIT ──────────────────────────────────────────────────
    public function edit($id)
    {
        if ($this->idPfl() != 1) {
            return redirect()->to('competence')->with('error', 'Accès refusé.');
        }

        $db         = \Config\Database::connect();
        $competence = $db->table('competence')->where('id_Cmp', $id)->get()->getRowArray();

        if (!$competence) {
            return redirect()->to('competence')->with('error', 'Compétence introuvable.');
        }

        return view('rh/competence/edit', [
            'title'      => 'Modifier la compétence',
            'competence' => $competence,
            'idPfl'      => $this->idPfl(),
        ]);
    }

    // ── UPDATE ────────────────────────────────────────────────
    public function update($id)
    {
        if ($this->idPfl() != 1) {
            return redirect()->to('competence')->with('error', 'Accès refusé.');
        }

        $db         = \Config\Database::connect();
        $competence = $db->table('competence')->where('id_Cmp', $id)->get()->getRowArray();

        if (!$competence) {
            return redirect()->to('competence')->with('error', 'Compétence introuvable.');
        }

        if (!$this->validate([
            'Libelle_Cmp' => "required|min_length[2]|max_length[150]|is_unique[competence.Libelle_Cmp,id_Cmp,{$id}]",
        ])) {
            return redirect()->back()->withInput()
                             ->with('errors', $this->validator->getErrors());
        }

        $db->table('competence')->where('id_Cmp', $id)->update([
            'Libelle_Cmp' => ucfirst(trim($this->request->getPost('Libelle_Cmp'))),
        ]);

        $this->log->insert([
            'Action_Log'      => 'UPDATE',
            'Module_Log'      => 'Competence',
            'Description_Log' => 'Modification compétence ID : ' . $id,
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => $this->idEmp(),
        ]);

        return redirect()->to('competence/show/' . $id)->with('success', 'Compétence modifiée avec succès.');
    }

    // ── DELETE ────────────────────────────────────────────────
    public function delete($id)
    {
        if ($this->idPfl() != 1) {
            return redirect()->to('competence')->with('error', 'Accès refusé.');
        }

        $db         = \Config\Database::connect();
        $competence = $db->table('competence')->where('id_Cmp', $id)->get()->getRowArray();

        if (!$competence) {
            return redirect()->to('competence')->with('error', 'Compétence introuvable.');
        }

        $nbAttributions = $db->table('obtenir')->where('id_Cmp', $id)->countAllResults();
        if ($nbAttributions > 0) {
            return redirect()->to('competence/show/' . $id)
                             ->with('error', 'Impossible de supprimer : ' . $nbAttributions
                                 . ' employé(s) possèdent cette compétence. Retirez-la d\'abord.');
        }

        $db->table('competence')->where('id_Cmp', $id)->delete();

        $this->log->insert([
            'Action_Log'      => 'DELETE',
            'Module_Log'      => 'Competence',
            'Description_Log' => 'Suppression compétence : ' . $competence['Libelle_Cmp'],
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => $this->idEmp(),
        ]);

        return redirect()->to('competence')->with('success', 'Compétence supprimée.');
    }

    // ── ATTRIBUER ─────────────────────────────────────────────
    public function attribuer($idCmp)
    {
        if ($this->idPfl() != 1) {
            return redirect()->to('competence')->with('error', 'Accès refusé.');
        }

        $db         = \Config\Database::connect();
        $competence = $db->table('competence')->where('id_Cmp', $idCmp)->get()->getRowArray();

        if (!$competence) {
            return redirect()->to('competence')->with('error', 'Compétence introuvable.');
        }

        $idEmpCible = (int)$this->request->getPost('id_Emp');
        $niveau     = $this->request->getPost('Niveau_Obt');
        $date       = $this->request->getPost('Dte_Obt') ?: date('Y-m-d');

        if (!$idEmpCible || !in_array($niveau, ['debutant', 'intermediaire', 'avance'])) {
            return redirect()->to('competence/show/' . $idCmp)->with('error', 'Données invalides.');
        }

        $existant = $db->table('obtenir')
            ->where('id_Emp', $idEmpCible)
            ->where('id_Cmp', $idCmp)
            ->get()->getRowArray();

        if ($existant) {
            return redirect()->to('competence/show/' . $idCmp)
                             ->with('error', 'Cet employé possède déjà cette compétence. Utilisez "Modifier le niveau".');
        }

        $db->table('obtenir')->insert([
            'Dte_Obt'    => $date,
            'Niveau_Obt' => $niveau,
            'id_Emp'     => $idEmpCible,
            'id_Cmp'     => (int)$idCmp,
        ]);

        $this->notif->envoyer(
            $idEmpCible,
            'Nouvelle compétence attribuée',
            'La compétence "' . $competence['Libelle_Cmp'] . '" (niveau : ' . $niveau . ') a été ajoutée à votre profil.',
            'competence',
            base_url('competence/show/' . $idCmp),
            $this->idEmp()
        );

        $this->log->insert([
            'Action_Log'      => 'ATTRIBUER',
            'Module_Log'      => 'Competence',
            'Description_Log' => 'Attribution compétence "' . $competence['Libelle_Cmp']
                               . '" (niveau : ' . $niveau . ') à l\'employé ID : ' . $idEmpCible,
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => $this->idEmp(),
        ]);

        return redirect()->to('competence/show/' . $idCmp)->with('success', 'Compétence attribuée avec succès.');
    }

    // ── MODIFIER NIVEAU ───────────────────────────────────────
    public function modifierNiveau($idObt)
    {
        if ($this->idPfl() != 1) {
            return redirect()->to('competence')->with('error', 'Accès refusé.');
        }

        $db          = \Config\Database::connect();
        $attribution = $db->table('obtenir')->where('id_Obt', $idObt)->get()->getRowArray();

        if (!$attribution) {
            return redirect()->to('competence')->with('error', 'Attribution introuvable.');
        }

        $niveau = $this->request->getPost('Niveau_Obt');
        $date   = $this->request->getPost('Dte_Obt') ?: $attribution['Dte_Obt'];

        if (!in_array($niveau, ['debutant', 'intermediaire', 'avance'])) {
            return redirect()->back()->with('error', 'Niveau invalide.');
        }

        $db->table('obtenir')->where('id_Obt', $idObt)->update([
            'Niveau_Obt' => $niveau,
            'Dte_Obt'    => $date,
        ]);

        $competence = $db->table('competence')->where('id_Cmp', $attribution['id_Cmp'])->get()->getRowArray();

        $this->notif->envoyer(
            $attribution['id_Emp'],
            'Niveau de compétence mis à jour',
            'Votre niveau pour la compétence "' . ($competence['Libelle_Cmp'] ?? '')
            . '" a été mis à jour : ' . $niveau . '.',
            'competence',
            base_url('competence/show/' . $attribution['id_Cmp']),
            $this->idEmp()
        );

        $this->log->insert([
            'Action_Log'      => 'UPDATE_NIVEAU',
            'Module_Log'      => 'Competence',
            'Description_Log' => 'Mise à jour niveau attribution ID : ' . $idObt . ' → ' . $niveau,
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => $this->idEmp(),
        ]);

        return redirect()->to('competence/show/' . $attribution['id_Cmp'])->with('success', 'Niveau mis à jour.');
    }

    // ── RETIRER ───────────────────────────────────────────────
    public function retirer($idObt)
    {
        if ($this->idPfl() != 1) {
            return redirect()->to('competence')->with('error', 'Accès refusé.');
        }

        $db          = \Config\Database::connect();
        $attribution = $db->table('obtenir')->where('id_Obt', $idObt)->get()->getRowArray();

        if (!$attribution) {
            return redirect()->to('competence')->with('error', 'Attribution introuvable.');
        }

        $idCmp = $attribution['id_Cmp'];
        $db->table('obtenir')->where('id_Obt', $idObt)->delete();

        $competence = $db->table('competence')->where('id_Cmp', $idCmp)->get()->getRowArray();

        $this->notif->envoyer(
            $attribution['id_Emp'],
            'Compétence retirée de votre profil',
            'La compétence "' . ($competence['Libelle_Cmp'] ?? '') . '" a été retirée de votre profil.',
            'competence',
            base_url('competence'),
            $this->idEmp()
        );

        $this->log->insert([
            'Action_Log'      => 'RETIRER',
            'Module_Log'      => 'Competence',
            'Description_Log' => 'Retrait compétence ID : ' . $idCmp
                               . ' de l\'employé ID : ' . $attribution['id_Emp'],
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => $this->idEmp(),
        ]);

        return redirect()->to('competence/show/' . $idCmp)->with('success', 'Compétence retirée.');
    }

    // ── PAR EMPLOYÉ ───────────────────────────────────────────
    public function parEmploye($idEmpCible)
    {
        $db    = \Config\Database::connect();
        $idPfl = $this->idPfl();
        $idDir = session()->get('id_Dir');

        $employe = $db->table('employe')
            ->select('employe.*, direction.Nom_Dir, grade.Libelle_Grd')
            ->join('direction', 'direction.id_Dir = employe.id_Dir', 'left')
            ->join('grade',     'grade.id_Grd = employe.id_Grd',     'left')
            ->where('employe.id_Emp', $idEmpCible)
            ->get()->getRowArray();

        if (!$employe) {
            return redirect()->to('competence')->with('error', 'Employé introuvable.');
        }

        if ($idPfl == 2 && $employe['id_Dir'] != $idDir) {
            return redirect()->to('competence')->with('error', 'Accès refusé.');
        }

        $competences = $db->table('obtenir')
            ->select('obtenir.id_Obt, obtenir.Niveau_Obt, obtenir.Dte_Obt,
                      competence.id_Cmp, competence.Libelle_Cmp')
            ->join('competence', 'competence.id_Cmp = obtenir.id_Cmp', 'left')
            ->where('obtenir.id_Emp', $idEmpCible)
            ->orderBy('competence.Libelle_Cmp')
            ->get()->getResultArray();

        $dejaIds           = array_column($competences, 'id_Cmp');
        $toutesCompetences = $db->table('competence')->orderBy('Libelle_Cmp')->get()->getResultArray();
        $competencesDispo  = array_values(array_filter($toutesCompetences, fn($c) => !in_array($c['id_Cmp'], $dejaIds)));

        return view('rh/competence/par_employe', [
            'title'            => 'Compétences de ' . $employe['Prenom_Emp'] . ' ' . $employe['Nom_Emp'],
            'employe'          => $employe,
            'competences'      => $competences,
            'competencesDispo' => $competencesDispo,
            'idPfl'            => $idPfl,
            'idEmp'            => $this->idEmp(),
        ]);
    }
}