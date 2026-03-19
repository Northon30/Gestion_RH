<?php

namespace App\Controllers;

use App\Models\NotificationModel;
use App\Models\ActivityLogModel;
use App\Models\EmployeModel;

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

    private function profileView(string $page, array $data = []): string
    {
        $folder = match ($this->idPfl()) {
            1       => 'rh',
            2       => 'chef',
            3       => 'employe',
            default => 'employe',
        };
        return view("{$folder}/competence/{$page}", $data);
    }

    private function getIdDir(): int
    {
        $emp = (new EmployeModel())->find($this->idEmp());
        return (int) ($emp['id_Dir'] ?? 0);
    }

    // ── Helper : requête obtenir avec filtre id_Emp NOT NULL ──
    // Exclut les entrées prévues (relation tertiaire formation)
    private function queryObtenir(\CodeIgniter\Database\BaseConnection $db): \CodeIgniter\Database\BaseBuilder
    {
        return $db->table('obtenir')
            ->select('obtenir.id_Obt, obtenir.Niveau_Obt, obtenir.Dte_Obt,
                      obtenir.id_Frm,
                      employe.id_Emp, employe.Nom_Emp, employe.Prenom_Emp,
                      employe.Email_Emp, employe.Disponibilite_Emp,
                      direction.id_Dir, direction.Nom_Dir,
                      competence.id_Cmp, competence.Libelle_Cmp,
                      grade.Libelle_Grd')
            ->join('employe',    'employe.id_Emp = obtenir.id_Emp',    'inner') // INNER = exclut id_Emp NULL
            ->join('direction',  'direction.id_Dir = employe.id_Dir',  'left')
            ->join('competence', 'competence.id_Cmp = obtenir.id_Cmp', 'left')
            ->join('grade',      'grade.id_Grd = employe.id_Grd',      'left')
            ->where('obtenir.id_Emp IS NOT NULL'); // double sécurité
    }

    // ══════════════════════════════════════════════════════════
    // INDEX
    // ══════════════════════════════════════════════════════════
    public function index()
    {
        $db    = \Config\Database::connect();
        $idPfl = $this->idPfl();
        $idEmp = $this->idEmp();

        // ── Employé : uniquement ses propres compétences ──
        if ($idPfl == 3) {
            $competences = $db->table('obtenir')
                ->select('obtenir.id_Obt, obtenir.Niveau_Obt, obtenir.Dte_Obt,
                          obtenir.id_Frm,
                          competence.id_Cmp, competence.Libelle_Cmp,
                          formation.Titre_Frm')
                ->join('competence', 'competence.id_Cmp = obtenir.id_Cmp', 'left')
                ->join('formation',  'formation.id_Frm  = obtenir.id_Frm',  'left')
                ->where('obtenir.id_Emp', $idEmp)
                ->where('obtenir.id_Emp IS NOT NULL')
                ->orderBy('competence.Libelle_Cmp')
                ->get()->getResultArray();

            $nbDebutant = count(array_filter($competences, fn($c) => $c['Niveau_Obt'] === 'debutant'));
            $nbInter    = count(array_filter($competences, fn($c) => $c['Niveau_Obt'] === 'intermediaire'));
            $nbAvance   = count(array_filter($competences, fn($c) => $c['Niveau_Obt'] === 'avance'));

            return $this->profileView('index', [
                'title'       => 'Mes compétences',
                'competences' => $competences,
                'nbDebutant'  => $nbDebutant,
                'nbInter'     => $nbInter,
                'nbAvance'    => $nbAvance,
                'idPfl'       => $idPfl,
                'idEmp'       => $idEmp,
            ]);
        }

        // ── RH / Chef : référentiel complet avec stats ──
        // Compétences — stats uniquement sur les id_Emp réels (pas NULL)
        $competences = $db->table('competence')
            ->select('competence.id_Cmp, competence.Libelle_Cmp,
                      COUNT(DISTINCT CASE WHEN obtenir.id_Emp IS NOT NULL THEN obtenir.id_Emp END) AS nb_employes,
                      SUM(CASE WHEN obtenir.id_Emp IS NOT NULL AND obtenir.Niveau_Obt = "debutant"      THEN 1 ELSE 0 END) AS nb_debutant,
                      SUM(CASE WHEN obtenir.id_Emp IS NOT NULL AND obtenir.Niveau_Obt = "intermediaire" THEN 1 ELSE 0 END) AS nb_intermediaire,
                      SUM(CASE WHEN obtenir.id_Emp IS NOT NULL AND obtenir.Niveau_Obt = "avance"        THEN 1 ELSE 0 END) AS nb_avance')
            ->join('obtenir', 'obtenir.id_Cmp = competence.id_Cmp', 'left')
            ->groupBy('competence.id_Cmp')
            ->orderBy('competence.Libelle_Cmp')
            ->get()->getResultArray();

        // Résultats de recherche — uniquement id_Emp NOT NULL
        $query = $this->queryObtenir($db);

        if ($idPfl == 2) {
            $query->where('employe.id_Dir', $this->getIdDir());
        }

        $resultats = $query->orderBy('employe.Nom_Emp')->get()->getResultArray();

        $directions = $db->table('direction')->orderBy('Nom_Dir')->get()->getResultArray();

        // Stats globales — uniquement id_Emp NOT NULL
        $totalCompetences  = count($competences);
        $totalAttributions = $db->table('obtenir')->where('id_Emp IS NOT NULL')->countAllResults();
        $totalDebutant     = $db->table('obtenir')->where('id_Emp IS NOT NULL')->where('Niveau_Obt', 'debutant')->countAllResults();
        $totalInter        = $db->table('obtenir')->where('id_Emp IS NOT NULL')->where('Niveau_Obt', 'intermediaire')->countAllResults();
        $totalAvance       = $db->table('obtenir')->where('id_Emp IS NOT NULL')->where('Niveau_Obt', 'avance')->countAllResults();

        return $this->profileView('index', [
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
            'idEmp'             => $idEmp,
        ]);
    }

    // ══════════════════════════════════════════════════════════
    // SHOW
    // ══════════════════════════════════════════════════════════
    public function show($id)
    {
        $db    = \Config\Database::connect();
        $idPfl = $this->idPfl();

        if ($idPfl == 3) {
            return redirect()->to('competence')->with('error', 'Accès refusé.');
        }

        $competence = $db->table('competence')->where('id_Cmp', $id)->get()->getRowArray();

        if (!$competence) {
            return redirect()->to('competence')->with('error', 'Compétence introuvable.');
        }

        $idDir = ($idPfl == 2) ? $this->getIdDir() : null;

        // Filtres GET
        $filtreNiveau    = $this->request->getGet('niveau')     ?? '';
        $filtreIdDir     = $this->request->getGet('id_Dir')     ?? '';
        $filtreRecherche = trim($this->request->getGet('recherche') ?? '');
        $filtreDateFrom  = $this->request->getGet('date_from')  ?? '';
        $filtreDateTo    = $this->request->getGet('date_to')    ?? '';

        // Requête employés avec cette compétence — INNER JOIN exclut id_Emp NULL
        $query = $db->table('obtenir')
            ->select('obtenir.id_Obt, obtenir.Niveau_Obt, obtenir.Dte_Obt, obtenir.id_Frm,
                      employe.id_Emp, employe.Nom_Emp, employe.Prenom_Emp,
                      employe.Email_Emp, employe.Disponibilite_Emp,
                      direction.id_Dir, direction.Nom_Dir,
                      grade.Libelle_Grd,
                      formation.Titre_Frm')
            ->join('employe',   'employe.id_Emp = obtenir.id_Emp',    'inner') // INNER = exclut NULL
            ->join('direction', 'direction.id_Dir = employe.id_Dir',  'left')
            ->join('grade',     'grade.id_Grd = employe.id_Grd',      'left')
            ->join('formation', 'formation.id_Frm = obtenir.id_Frm',  'left')
            ->where('obtenir.id_Cmp', (int)$id)
            ->where('obtenir.id_Emp IS NOT NULL');

        if ($filtreNiveau)   $query->where('obtenir.Niveau_Obt', $filtreNiveau);
        if ($filtreIdDir)    $query->where('employe.id_Dir', (int)$filtreIdDir);
        if ($filtreDateFrom) $query->where('obtenir.Dte_Obt >=', $filtreDateFrom);
        if ($filtreDateTo)   $query->where('obtenir.Dte_Obt <=', $filtreDateTo);

        if ($filtreRecherche) {
            $query->groupStart()
                  ->like('employe.Nom_Emp',    $filtreRecherche)
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

        // Employés sans cette compétence (profil 3 seulement)
        $dejaCmpIds = array_column($employes, 'id_Emp');
        $empQuery   = $db->table('employe')
            ->select('employe.id_Emp, employe.Nom_Emp, employe.Prenom_Emp,
                      direction.Nom_Dir, grade.Libelle_Grd')
            ->join('direction', 'direction.id_Dir = employe.id_Dir', 'left')
            ->join('grade',     'grade.id_Grd = employe.id_Grd',     'left')
            ->where('employe.id_Pfl', 3)
            ->orderBy('employe.Nom_Emp');

        if ($idPfl == 2) {
            $empQuery->where('employe.id_Dir', $idDir);
        }

        if (!empty($dejaCmpIds)) {
            $empQuery->whereNotIn('employe.id_Emp', $dejaCmpIds);
        }

        $employesSans = $empQuery->get()->getResultArray();

        // Compétences prévues pour formations (id_Emp = NULL) — pour info RH
        $formationsPrevues = [];
        if ($idPfl == 1) {
            $formationsPrevues = $db->table('obtenir')
                ->select('formation.id_Frm, formation.Titre_Frm,
                          formation.DateDebut_Frm, formation.DateFin_Frm,
                          formation.Statut_Frm')
                ->join('formation', 'formation.id_Frm = obtenir.id_Frm', 'left')
                ->where('obtenir.id_Cmp', (int)$id)
                ->where('obtenir.id_Emp IS NULL')
                ->orderBy('formation.DateDebut_Frm', 'DESC')
                ->get()->getResultArray();
        }

        return $this->profileView('show', [
            'title'            => 'Compétence : ' . $competence['Libelle_Cmp'],
            'competence'       => $competence,
            'employes'         => $employes,
            'employesSans'     => $employesSans,
            'formationsPrevues'=> $formationsPrevues,
            'nbDebutant'       => $nbDebutant,
            'nbInter'          => $nbInter,
            'nbAvance'         => $nbAvance,
            'directions'       => $directions,
            'filtreNiveau'     => $filtreNiveau,
            'filtreIdDir'      => $filtreIdDir,
            'filtreRecherche'  => $filtreRecherche,
            'filtreDateFrom'   => $filtreDateFrom,
            'filtreDateTo'     => $filtreDateTo,
            'idPfl'            => $idPfl,
            'idEmp'            => $this->idEmp(),
        ]);
    }

    // ══════════════════════════════════════════════════════════
    // CREATE — RH uniquement
    // ══════════════════════════════════════════════════════════
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

    // ══════════════════════════════════════════════════════════
    // STORE — RH uniquement
    // ══════════════════════════════════════════════════════════
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

        return redirect()->to('competence/show/' . $newId)
                         ->with('success', 'Compétence créée avec succès.');
    }

    // ══════════════════════════════════════════════════════════
    // EDIT — RH uniquement
    // ══════════════════════════════════════════════════════════
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

        // Stats actuelles pour info dans la vue edit
        $nbEmployes = $db->table('obtenir')
            ->where('id_Cmp', $id)
            ->where('id_Emp IS NOT NULL')
            ->countAllResults();

        return view('rh/competence/edit', [
            'title'      => 'Modifier la compétence',
            'competence' => $competence,
            'nbEmployes' => $nbEmployes,
            'idPfl'      => $this->idPfl(),
        ]);
    }

    // ══════════════════════════════════════════════════════════
    // UPDATE — RH uniquement
    // ══════════════════════════════════════════════════════════
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

        $nouveauLibelle = ucfirst(trim($this->request->getPost('Libelle_Cmp')));

        $db->table('competence')->where('id_Cmp', $id)->update([
            'Libelle_Cmp' => $nouveauLibelle,
        ]);

        $this->log->insert([
            'Action_Log'      => 'UPDATE',
            'Module_Log'      => 'Competence',
            'Description_Log' => 'Modification compétence ID : ' . $id
                               . ' → ' . $nouveauLibelle,
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => $this->idEmp(),
        ]);

        return redirect()->to('competence/show/' . $id)
                         ->with('success', 'Compétence modifiée avec succès.');
    }

    // ══════════════════════════════════════════════════════════
    // DELETE — RH uniquement
    // ══════════════════════════════════════════════════════════
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

        // Vérifier uniquement les attributions réelles (id_Emp NOT NULL)
        $nbAttributions = $db->table('obtenir')
            ->where('id_Cmp', $id)
            ->where('id_Emp IS NOT NULL')
            ->countAllResults();

        if ($nbAttributions > 0) {
            return redirect()->to('competence/show/' . $id)
                             ->with('error', 'Impossible de supprimer : '
                                 . $nbAttributions . ' employé(s) possèdent cette compétence. '
                                 . 'Retirez-la d\'abord de tous les profils.');
        }

        // Supprimer aussi les entrées prévues (id_Emp = NULL) liées à des formations
        $db->table('obtenir')->where('id_Cmp', $id)->delete();
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

    // ══════════════════════════════════════════════════════════
    // ATTRIBUER — RH uniquement
    // ══════════════════════════════════════════════════════════
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

        $idEmpCible = (int) $this->request->getPost('id_Emp');
        $niveau     = $this->request->getPost('Niveau_Obt');
        $date       = $this->request->getPost('Dte_Obt') ?: date('Y-m-d');

        if (!$idEmpCible || !in_array($niveau, ['debutant', 'intermediaire', 'avance'])) {
            return redirect()->to('competence/show/' . $idCmp)
                             ->with('error', 'Données invalides — employé et niveau obligatoires.');
        }

        // Vérifier si l'employé a déjà cette compétence (attribution réelle)
        $existant = $db->table('obtenir')
            ->where('id_Emp', $idEmpCible)
            ->where('id_Cmp', (int)$idCmp)
            ->where('id_Emp IS NOT NULL')
            ->get()->getRowArray();

        if ($existant) {
            return redirect()->to('competence/show/' . $idCmp)
                             ->with('error', 'Cet employé possède déjà cette compétence. '
                                 . 'Utilisez "Modifier le niveau".');
        }

        $db->table('obtenir')->insert([
            'Dte_Obt'    => $date,
            'Niveau_Obt' => $niveau,
            'id_Emp'     => $idEmpCible,
            'id_Cmp'     => (int) $idCmp,
            'id_Frm'     => null,
        ]);

        $employe = (new EmployeModel())->find($idEmpCible);

        $this->notif->envoyer(
            $idEmpCible,
            'Nouvelle compétence attribuée',
            'La compétence "' . $competence['Libelle_Cmp']
            . '" (niveau : ' . $niveau . ') a été ajoutée à votre profil par le RH.',
            'competence',
            base_url('competence'),
            $this->idEmp()
        );

        $this->log->insert([
            'Action_Log'      => 'ATTRIBUER',
            'Module_Log'      => 'Competence',
            'Description_Log' => 'Attribution "' . $competence['Libelle_Cmp']
                               . '" niveau ' . $niveau
                               . ' → employé ID : ' . $idEmpCible,
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => $this->idEmp(),
        ]);

        return redirect()->to('competence/show/' . $idCmp)
                         ->with('success', 'Compétence attribuée à '
                             . ($employe['Prenom_Emp'] ?? '') . ' '
                             . ($employe['Nom_Emp'] ?? '') . '.');
    }

    // ══════════════════════════════════════════════════════════
    // MODIFIER NIVEAU — RH uniquement
    // ══════════════════════════════════════════════════════════
    public function modifierNiveau($idObt)
    {
        if ($this->idPfl() != 1) {
            return redirect()->to('competence')->with('error', 'Accès refusé.');
        }

        $db          = \Config\Database::connect();
        $attribution = $db->table('obtenir')
            ->where('id_Obt', $idObt)
            ->where('id_Emp IS NOT NULL') // Ne jamais modifier une entrée prévue
            ->get()->getRowArray();

        if (!$attribution) {
            return redirect()->to('competence')->with('error', 'Attribution introuvable.');
        }

        $niveau = $this->request->getPost('Niveau_Obt');
        $date   = $this->request->getPost('Dte_Obt') ?: ($attribution['Dte_Obt'] ?? date('Y-m-d'));

        if (!in_array($niveau, ['debutant', 'intermediaire', 'avance'])) {
            return redirect()->back()->with('error', 'Niveau invalide.');
        }

        $ancienNiveau = $attribution['Niveau_Obt'];

        $db->table('obtenir')->where('id_Obt', $idObt)->update([
            'Niveau_Obt' => $niveau,
            'Dte_Obt'    => $date,
        ]);

        $competence = $db->table('competence')
            ->where('id_Cmp', $attribution['id_Cmp'])
            ->get()->getRowArray();

        $this->notif->envoyer(
            $attribution['id_Emp'],
            'Niveau de compétence mis à jour',
            'Votre niveau pour la compétence "' . ($competence['Libelle_Cmp'] ?? '')
            . '" est passé de ' . $ancienNiveau . ' à ' . $niveau . '.',
            'competence',
            base_url('competence'),
            $this->idEmp()
        );

        $this->log->insert([
            'Action_Log'      => 'UPDATE_NIVEAU',
            'Module_Log'      => 'Competence',
            'Description_Log' => 'Mise à jour niveau "' . ($competence['Libelle_Cmp'] ?? '')
                               . '" : ' . $ancienNiveau . ' → ' . $niveau
                               . ' (employé ID : ' . $attribution['id_Emp'] . ')',
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => $this->idEmp(),
        ]);

        return redirect()->to('competence/show/' . $attribution['id_Cmp'])
                         ->with('success', 'Niveau mis à jour : ' . $ancienNiveau . ' → ' . $niveau . '.');
    }

    // ══════════════════════════════════════════════════════════
    // RETIRER — RH uniquement
    // ══════════════════════════════════════════════════════════
    public function retirer($idObt)
    {
        if ($this->idPfl() != 1) {
            return redirect()->to('competence')->with('error', 'Accès refusé.');
        }

        $db          = \Config\Database::connect();
        $attribution = $db->table('obtenir')
            ->where('id_Obt', $idObt)
            ->where('id_Emp IS NOT NULL') // Ne jamais retirer une entrée prévue
            ->get()->getRowArray();

        if (!$attribution) {
            return redirect()->to('competence')->with('error', 'Attribution introuvable.');
        }

        $idCmp = $attribution['id_Cmp'];

        $db->table('obtenir')->where('id_Obt', $idObt)->delete();

        $competence = $db->table('competence')->where('id_Cmp', $idCmp)->get()->getRowArray();
        $employe    = (new EmployeModel())->find($attribution['id_Emp']);

        $this->notif->envoyer(
            $attribution['id_Emp'],
            'Compétence retirée de votre profil',
            'La compétence "' . ($competence['Libelle_Cmp'] ?? '')
            . '" a été retirée de votre profil par le RH.',
            'competence',
            base_url('competence'),
            $this->idEmp()
        );

        $this->log->insert([
            'Action_Log'      => 'RETIRER',
            'Module_Log'      => 'Competence',
            'Description_Log' => 'Retrait "' . ($competence['Libelle_Cmp'] ?? '')
                               . '" de ' . ($employe['Prenom_Emp'] ?? '') . ' '
                               . ($employe['Nom_Emp'] ?? '')
                               . ' (ID : ' . $attribution['id_Emp'] . ')',
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => $this->idEmp(),
        ]);

        return redirect()->to('competence/show/' . $idCmp)
                         ->with('success', 'Compétence retirée de '
                             . ($employe['Prenom_Emp'] ?? '') . ' '
                             . ($employe['Nom_Emp'] ?? '') . '.');
    }

    // ══════════════════════════════════════════════════════════
    // PAR EMPLOYÉ — RH et Chef
    // ══════════════════════════════════════════════════════════
    public function parEmploye($idEmpCible)
    {
        $db    = \Config\Database::connect();
        $idPfl = $this->idPfl();

        if ($idPfl == 3) {
            return redirect()->to('competence');
        }

        $employe = $db->table('employe')
            ->select('employe.*, direction.Nom_Dir, grade.Libelle_Grd')
            ->join('direction', 'direction.id_Dir = employe.id_Dir', 'left')
            ->join('grade',     'grade.id_Grd = employe.id_Grd',     'left')
            ->where('employe.id_Emp', $idEmpCible)
            ->get()->getRowArray();

        if (!$employe) {
            return redirect()->to('competence')->with('error', 'Employé introuvable.');
        }

        if ($idPfl == 2) {
            $idDir = $this->getIdDir();
            if ($employe['id_Dir'] != $idDir) {
                return redirect()->to('competence')->with('error', 'Accès refusé.');
            }
        }

        // Compétences de l'employé — uniquement attributions réelles
        $competences = $db->table('obtenir')
            ->select('obtenir.id_Obt, obtenir.Niveau_Obt, obtenir.Dte_Obt, obtenir.id_Frm,
                      competence.id_Cmp, competence.Libelle_Cmp,
                      formation.Titre_Frm')
            ->join('competence', 'competence.id_Cmp = obtenir.id_Cmp', 'left')
            ->join('formation',  'formation.id_Frm  = obtenir.id_Frm',  'left')
            ->where('obtenir.id_Emp', $idEmpCible)
            ->where('obtenir.id_Emp IS NOT NULL')
            ->orderBy('competence.Libelle_Cmp')
            ->get()->getResultArray();

        $dejaIds           = array_column($competences, 'id_Cmp');
        $toutesCompetences = $db->table('competence')->orderBy('Libelle_Cmp')->get()->getResultArray();
        $competencesDispo  = array_values(array_filter(
            $toutesCompetences,
            fn($c) => !in_array($c['id_Cmp'], $dejaIds)
        ));

        $nbDebutant = count(array_filter($competences, fn($c) => $c['Niveau_Obt'] === 'debutant'));
        $nbInter    = count(array_filter($competences, fn($c) => $c['Niveau_Obt'] === 'intermediaire'));
        $nbAvance   = count(array_filter($competences, fn($c) => $c['Niveau_Obt'] === 'avance'));

        return $this->profileView('par_employe', [
            'title'            => 'Compétences de ' . $employe['Prenom_Emp'] . ' ' . $employe['Nom_Emp'],
            'employe'          => $employe,
            'competences'      => $competences,
            'competencesDispo' => $competencesDispo,
            'nbDebutant'       => $nbDebutant,
            'nbInter'          => $nbInter,
            'nbAvance'         => $nbAvance,
            'idPfl'            => $idPfl,
            'idEmp'            => $this->idEmp(),
        ]);
    }
}