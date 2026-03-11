<?php

namespace App\Controllers;

use App\Models\EmployeModel;
use App\Models\DirectionModel;
use App\Models\GradeModel;
use App\Models\ProfilModel;
use App\Models\ActivityLogModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;

class EmployeController extends BaseController
{
    protected $model;
    protected $log;

    public function __construct()
    {
        $this->model = new EmployeModel();
        $this->log   = new ActivityLogModel();
    }

    // Seul le RH (id_Pfl = 1) peut acceder a ce module
    private function checkAccess()
    {
        if ((int) session()->get('id_Pfl') !== 1) {
            return redirect()->to('/dashboard')->with('error', 'Acces non autorise.');
        }
        return null;
    }

    // ===== INDEX =====
    public function index()
{
    $redirect = $this->checkAccess();
    if ($redirect) return $redirect;

    $directionModel = new DirectionModel();
    $gradeModel     = new GradeModel();
    $profilModel    = new ProfilModel();

    $db = \Config\Database::connect();

    $builder = $db->table('employe')
        ->select('employe.*, direction.Nom_Dir, grade.Libelle_Grd, profil.Libelle_Pfl')
        ->join('direction', 'direction.id_Dir = employe.id_Dir', 'left')
        ->join('grade',     'grade.id_Grd = employe.id_Grd',     'left')
        ->join('profil',    'profil.id_Pfl = employe.id_Pfl',    'left');

    // Recuperation de tous les parametres GET
    $search        = trim($this->request->getGet('q')              ?? '');
    $filtreDir     = $this->request->getGet('id_Dir')              ?? '';
    $filtreGrd     = $this->request->getGet('id_Grd')              ?? '';
    $filtrePfl     = $this->request->getGet('id_Pfl')              ?? '';
    $filtreSexe    = $this->request->getGet('sexe')                ?? '';
    $filtreDispo   = $this->request->getGet('disponibilite')       ?? '';
    $filtreAnneEmb = $this->request->getGet('annee_embauche')      ?? '';

    // Filtre : recherche textuelle sur nom, prenom, email, telephone
    if ($search !== '') {
        $builder->groupStart()
            ->like('employe.Nom_Emp',        $search)
            ->orLike('employe.Prenom_Emp',   $search)
            ->orLike('employe.Email_Emp',    $search)
            ->orLike('employe.Telephone_Emp', $search)
            ->groupEnd();
    }

    // Filtre : direction
    if ($filtreDir !== '') {
        $builder->where('employe.id_Dir', $filtreDir);
    }

    // Filtre : grade
    if ($filtreGrd !== '') {
        $builder->where('employe.id_Grd', $filtreGrd);
    }

    // Filtre : profil
    if ($filtrePfl !== '') {
        $builder->where('employe.id_Pfl', $filtrePfl);
    }

    // Filtre : sexe (0 = femme, 1 = homme)
    if ($filtreSexe !== '') {
        $builder->where('employe.Sexe_Emp', $filtreSexe);
    }

    // Filtre : disponibilite (0 = absent, 1 = disponible)
    if ($filtreDispo !== '') {
        $builder->where('employe.Disponibilite_Emp', $filtreDispo);
    }

    // Filtre : annee d'embauche via YEAR()
    if ($filtreAnneEmb !== '') {
        $builder->where('YEAR(employe.DateEmbauche_Emp)', (int) $filtreAnneEmb);
    }

    $employes = $builder->orderBy('employe.Nom_Emp', 'ASC')->get()->getResultArray();

    return view('rh/employe/index', [
        'title'         => 'Employes',
        'employes'      => $employes,
        'directions'    => $directionModel->findAll(),
        'grades'        => $gradeModel->findAll(),
        'profils'       => $profilModel->findAll(),
        'search'        => $search,
        'filtreDir'     => $filtreDir,
        'filtreGrd'     => $filtreGrd,
        'filtrePfl'     => $filtrePfl,
        'filtreSexe'    => $filtreSexe,
        'filtreDispo'   => $filtreDispo,
        'filtreAnneEmb' => $filtreAnneEmb,
    ]);
}

    // ===== SHOW =====
    public function show($id)
{
    $redirect = $this->checkAccess();
    if ($redirect) return $redirect;

    $db = \Config\Database::connect();

    // Employe
    $employe = $db->table('employe')
        ->select('employe.*, direction.Nom_Dir, grade.Libelle_Grd, profil.Libelle_Pfl')
        ->join('direction', 'direction.id_Dir = employe.id_Dir', 'left')
        ->join('grade',     'grade.id_Grd = employe.id_Grd',    'left')
        ->join('profil',    'profil.id_Pfl = employe.id_Pfl',   'left')
        ->where('employe.id_Emp', $id)
        ->get()->getRowArray();

    if (!$employe) {
        return redirect()->to('employe')->with('error', 'Employe introuvable.');
    }

    // Soldes conges
    $soldes = $db->table('solde_conge')
        ->select('solde_conge.*')
        ->where('solde_conge.id_Emp', $id)
        ->where('solde_conge.Annee_Sld', date('Y'))
        ->get()->getResultArray();

    // Conges 
    $conges = $db->table('conge')
        ->select('conge.*, type_conge.Libelle_Tcg')
        ->join('type_conge', 'type_conge.id_Tcg = conge.id_Tcg', 'left')
        ->where('conge.id_Emp', $id)
        ->orderBy('conge.DateDebut_Cge', 'DESC')
        ->get()->getResultArray();

    // Absences 
    $absences = $db->table('absence')
        ->select('absence.*, type_absence.Libelle_TAbs, piece_justificative.CheminFichier_PJ')
        ->join('type_absence',       'type_absence.id_TAbs = absence.id_TAbs',         'left')
        ->join('piece_justificative','piece_justificative.id_Abs = absence.id_Abs',    'left')
        ->where('absence.id_Emp', $id)
        ->orderBy('absence.DateDebut_Abs', 'DESC')
        ->get()->getResultArray();

    // Formations 
     $formations = $db->table('s_inscrire')
        ->select('s_inscrire.Stt_Ins, s_inscrire.Dte_Ins,
                  formation.Description_Frm, formation.DateDebut_Frm,
                  formation.DateFin_Frm, formation.Lieu_Frm, formation.Formateur_Frm')
        ->join('formation', 'formation.id_Frm = s_inscrire.id_Frm', 'left')
        ->where('s_inscrire.id_Emp', $id)
        ->orderBy('formation.DateDebut_Frm', 'DESC')
        ->get()->getResultArray();

    // Competences
    $competences = $db->table('obtenir')
        ->select('obtenir.Niveau_Obt, obtenir.Dte_Obt, competence.Libelle_Cmp')
        ->join('competence', 'competence.id_Cmp = obtenir.id_Cmp', 'left')
        ->where('obtenir.id_Emp', $id)
        ->get()->getResultArray();

    // Evenements 
    $evenements = $db->table('participer')
        ->select('evenement.Description_Evt, evenement.Date_Evt,
                  type_evenement.Libelle_Tev')
        ->join('evenement',      'evenement.id_Evt = participer.id_Evt',             'left')
        ->join('type_evenement', 'type_evenement.id_Tev = evenement.id_Tev',         'left')
        ->where('participer.id_Emp', $id)
        ->orderBy('evenement.Date_Evt', 'DESC')
        ->get()->getResultArray();

    return view('rh/employe/show', [
        'title'       => $employe['Nom_Emp'] . ' ' . $employe['Prenom_Emp'],
        'employe'     => $employe,
        'soldes'      => $soldes,
        'conges'      => $conges,
        'absences'    => $absences,
        'formations'  => $formations,
        'competences' => $competences,
        'evenements'  => $evenements,
    ]);
}

    // ===== CREATE =====
    public function create()
    {
        $redirect = $this->checkAccess();
        if ($redirect) return $redirect;

        $directionModel = new DirectionModel();
        $gradeModel     = new GradeModel();
        $profilModel    = new ProfilModel();

        return view('rh/employe/create', [
            'title'      => 'Nouvel Employe',
            'directions' => $directionModel->findAll(),
            'grades'     => $gradeModel->findAll(),
            'profils'    => $profilModel->findAll(),
        ]);
    }

    // ===== STORE =====
    public function store()
    {
        $redirect = $this->checkAccess();
        if ($redirect) return $redirect;

        $rules = [
            'Nom_Emp'           => 'required|min_length[2]|max_length[100]',
            'Prenom_Emp'        => 'required|min_length[2]|max_length[100]',
            'Email_Emp'         => 'required|valid_email|is_unique[employe.Email_Emp]',
            'Telephone_Emp'     => 'required',
            'Adresse_Emp'       => 'required',
            'Sexe_Emp'          => 'required|in_list[0,1]',
            'DateNaissance_Emp' => 'required',
            'id_Dir'            => 'required',
            'id_Grd'            => 'required',
            'id_Pfl'            => 'required',
            'Password_Emp'      => 'required|min_length[6]',
        ];

        if (!$this->validate($rules)) {
            $directionModel = new DirectionModel();
            $gradeModel     = new GradeModel();
            $profilModel    = new ProfilModel();

            return view('rh/employe/create', [
                'title'      => 'Nouvel Employe',
                'errors'     => $this->validator->getErrors(),
                'directions' => $directionModel->findAll(),
                'grades'     => $gradeModel->findAll(),
                'profils'    => $profilModel->findAll(),
            ]);
        }

        $empData = [
            'Nom_Emp'           => $this->request->getPost('Nom_Emp'),
            'Prenom_Emp'        => $this->request->getPost('Prenom_Emp'),
            'Email_Emp'         => $this->request->getPost('Email_Emp'),
            'Telephone_Emp'     => $this->request->getPost('Telephone_Emp'),
            'Adresse_Emp'       => $this->request->getPost('Adresse_Emp'),
            'Sexe_Emp'          => $this->request->getPost('Sexe_Emp'),
            'DateNaissance_Emp' => $this->request->getPost('DateNaissance_Emp'),
            'DateEmbauche_Emp'  => $this->request->getPost('DateEmbauche_Emp') ?: null,
            'Disponibilite_Emp' => $this->request->getPost('Disponibilite_Emp') ?? 1,
            'id_Dir'            => $this->request->getPost('id_Dir'),
            'id_Grd'            => $this->request->getPost('id_Grd'),
            'id_Pfl'            => $this->request->getPost('id_Pfl'),
            'Password_Emp'      => password_hash($this->request->getPost('Password_Emp'), PASSWORD_DEFAULT),
        ];

        $id = $this->model->insert($empData);

        if (!$id) {
            return redirect()->back()->withInput()->with('error', 'Erreur lors de la creation de l\'employe.');
        }

        // Creation du solde de conges pour l'annee en cours
        $soldeModel = new \App\Models\SoldeCongeModel();
        $soldeModel->insert([
            'Annee_Sld'        => date('Y'),
            'NbJoursDroit_Sld' => 30,
            'NbJoursPris_Sld'  => 0,
            'id_Emp'           => $id,
        ]);

        // Enregistrement du grade initial dans l'historique
        $attribuerModel = new \App\Models\AttribuerModel();
        $attribuerModel->insert([
            'Dte_Aff' => date('Y-m-d'),
            'id_Emp'  => $id,
            'id_Grd'  => $empData['id_Grd'],
        ]);

        $this->log->insert([
            'Action_Log'      => 'CREATE',
            'Module_Log'      => 'Employe',
            'Description_Log' => 'Creation employe : ' . $empData['Nom_Emp'] . ' ' . $empData['Prenom_Emp'],
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => session()->get('id_Emp'),
        ]);

        $action = $this->request->getPost('action');

        if ($action === 'new') {
            return redirect()->to('/employe/create')
                             ->with('success', 'Employe cree. Vous pouvez en saisir un autre.');
        }

        return redirect()->to('/employe/show/' . $id)
                         ->with('success', 'Employe cree avec succes.');
    }

    // ===== EDIT =====
    public function edit($id)
    {
        $redirect = $this->checkAccess();
        if ($redirect) return $redirect;

        $directionModel = new DirectionModel();
        $gradeModel     = new GradeModel();
        $profilModel    = new ProfilModel();

        $db = \Config\Database::connect();

        // On recupere via jointure pour avoir id_Grd dans le resultat
        $employe = $db->table('employe')
            ->select('employe.*, direction.Nom_Dir, grade.Libelle_Grd, profil.Libelle_Pfl')
            ->join('direction', 'direction.id_Dir = employe.id_Dir', 'left')
            ->join('grade',     'grade.id_Grd = employe.id_Grd',     'left')
            ->join('profil',    'profil.id_Pfl = employe.id_Pfl',    'left')
            ->where('employe.id_Emp', $id)
            ->get()
            ->getRowArray();

        if (!$employe) {
            return redirect()->to('/employe')->with('error', 'Employe introuvable.');
        }

        return view('rh/employe/edit', [
            'title'      => 'Modifier ' . $employe['Nom_Emp'] . ' ' . $employe['Prenom_Emp'],
            'employe'    => $employe,
            'directions' => $directionModel->findAll(),
            'grades'     => $gradeModel->findAll(),
            'profils'    => $profilModel->findAll(),
        ]);
    }

    // ===== UPDATE =====
    public function update($id)
    {
        $redirect = $this->checkAccess();
        if ($redirect) return $redirect;

        // On recupere via jointure pour avoir id_Grd present dans le tableau
        $db = \Config\Database::connect();
        $employe = $db->table('employe')
            ->select('employe.*')
            ->where('employe.id_Emp', $id)
            ->get()
            ->getRowArray();

        if (!$employe) {
            return redirect()->to('/employe')->with('error', 'Employe introuvable.');
        }

        $rules = [
            'Nom_Emp'           => 'required|min_length[2]|max_length[100]',
            'Prenom_Emp'        => 'required|min_length[2]|max_length[100]',
            'Email_Emp'         => "required|valid_email|is_unique[employe.Email_Emp,id_Emp,{$id}]",
            'Telephone_Emp'     => 'required',
            'Adresse_Emp'       => 'required',
            'Sexe_Emp'          => 'required|in_list[0,1]',
            'DateNaissance_Emp' => 'required',
            'id_Dir'            => 'required',
            'id_Grd'            => 'required',
            'id_Pfl'            => 'required',
        ];

        if (!$this->validate($rules)) {
            $directionModel = new DirectionModel();
            $gradeModel     = new GradeModel();
            $profilModel    = new ProfilModel();

            return view('rh/employe/edit', [
                'title'      => 'Modifier ' . $employe['Nom_Emp'],
                'errors'     => $this->validator->getErrors(),
                'employe'    => $employe,
                'directions' => $directionModel->findAll(),
                'grades'     => $gradeModel->findAll(),
                'profils'    => $profilModel->findAll(),
            ]);
        }

        $nouveauGrd = (int) $this->request->getPost('id_Grd');
        $ancienGrd  = (int) $employe['id_Grd'];

        $empData = [
            'Nom_Emp'           => $this->request->getPost('Nom_Emp'),
            'Prenom_Emp'        => $this->request->getPost('Prenom_Emp'),
            'Email_Emp'         => $this->request->getPost('Email_Emp'),
            'Telephone_Emp'     => $this->request->getPost('Telephone_Emp'),
            'Adresse_Emp'       => $this->request->getPost('Adresse_Emp'),
            'Sexe_Emp'          => $this->request->getPost('Sexe_Emp'),
            'DateNaissance_Emp' => $this->request->getPost('DateNaissance_Emp'),
            'DateEmbauche_Emp'  => $this->request->getPost('DateEmbauche_Emp') ?: null,
            'Disponibilite_Emp' => $this->request->getPost('Disponibilite_Emp') ?? 1,
            'id_Dir'            => $this->request->getPost('id_Dir'),
            'id_Grd'            => $nouveauGrd,
            'id_Pfl'            => $this->request->getPost('id_Pfl'),
        ];

        // Si le grade a change, on l'enregistre dans l'historique
        if ($nouveauGrd !== $ancienGrd) {
            $attribuerModel = new \App\Models\AttribuerModel();
            $attribuerModel->insert([
                'Dte_Aff' => date('Y-m-d'),
                'id_Emp'  => $id,
                'id_Grd'  => $nouveauGrd,
            ]);
        }

        $this->model->update($id, $empData);

        $this->log->insert([
            'Action_Log'      => 'UPDATE',
            'Module_Log'      => 'Employe',
            'Description_Log' => 'Modification employe ID : ' . $id . ' (' . $empData['Nom_Emp'] . ' ' . $empData['Prenom_Emp'] . ')',
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => session()->get('id_Emp'),
        ]);

        return redirect()->to('/employe/show/' . $id)
                         ->with('success', 'Employe modifie avec succes.');
    }

    // ===== DELETE =====
    public function delete($id)
    {
        $redirect = $this->checkAccess();
        if ($redirect) return $redirect;

        $employe = $this->model->find($id);

        if (!$employe) {
            return redirect()->to('/employe')->with('error', 'Employe introuvable.');
        }

        // On ne peut pas supprimer sa propre fiche
        if ((int) $id === (int) session()->get('id_Emp')) {
            return redirect()->to('/employe')->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');
        }

        $this->model->delete($id);

        $this->log->insert([
            'Action_Log'      => 'DELETE',
            'Module_Log'      => 'Employe',
            'Description_Log' => 'Suppression employe : ' . $employe['Nom_Emp'] . ' ' . $employe['Prenom_Emp'],
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => session()->get('id_Emp'),
        ]);

        return redirect()->to('/employe')
                         ->with('success', 'Employe supprime avec succes.');
    }

    // ===== EXPORT CSV =====
public function exportCsv()
{
    $redirect = $this->checkAccess();
    if ($redirect) return $redirect;

    $db      = \Config\Database::connect();
    $builder = $db->table('employe')
        ->select('employe.Nom_Emp, employe.Prenom_Emp, employe.Email_Emp,
                  employe.Telephone_Emp, employe.Adresse_Emp,
                  employe.Sexe_Emp, employe.DateNaissance_Emp,
                  employe.DateEmbauche_Emp, employe.Disponibilite_Emp,
                  direction.Nom_Dir, grade.Libelle_Grd, profil.Libelle_Pfl')
        ->join('direction', 'direction.id_Dir = employe.id_Dir', 'left')
        ->join('grade',     'grade.id_Grd = employe.id_Grd',     'left')
        ->join('profil',    'profil.id_Pfl = employe.id_Pfl',    'left');

    // Filtrer par ids si fournis
    $ids = $this->request->getGet('ids');
    if (!empty($ids)) {
        $idList = array_filter(explode(',', $ids), fn($v) => is_numeric($v));
        if (!empty($idList)) $builder->whereIn('employe.id_Emp', $idList);
    }

    $employes = $builder->orderBy('employe.Nom_Emp', 'ASC')->get()->getResultArray();

    $filename = 'employes_' . date('Ymd_His') . '.csv';

    header('Content-Type: text/csv; charset=UTF-8');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Cache-Control: no-cache, no-store, must-revalidate');

    $output = fopen('php://output', 'w');

    // BOM UTF-8 pour Excel
    fputs($output, "\xEF\xBB\xBF");

    // Entete
    fputcsv($output, [
        'Nom', 'Prenom', 'Email', 'Telephone', 'Adresse',
        'Sexe', 'Date Naissance', 'Date Embauche',
        'Disponibilite', 'Direction', 'Grade', 'Profil'
    ], ';');

    foreach ($employes as $emp) {
        fputcsv($output, [
            $emp['Nom_Emp'],
            $emp['Prenom_Emp'],
            $emp['Email_Emp'],
            $emp['Telephone_Emp'],
            $emp['Adresse_Emp'],
            (int)$emp['Sexe_Emp'] === 1 ? 'Homme' : 'Femme',
            !empty($emp['DateNaissance_Emp']) ? date('d/m/Y', strtotime($emp['DateNaissance_Emp'])) : '',
            !empty($emp['DateEmbauche_Emp'])  ? date('d/m/Y', strtotime($emp['DateEmbauche_Emp']))  : '',
            (int)$emp['Disponibilite_Emp'] === 1 ? 'Disponible' : 'Absent',
            $emp['Nom_Dir']      ?? '',
            $emp['Libelle_Grd']  ?? '',
            $emp['Libelle_Pfl']  ?? '',
        ], ';');
    }

    fclose($output);
    exit;
}

// ===== EXPORT EXCEL =====
public function exportExcel()
{
    $redirect = $this->checkAccess();
    if ($redirect) return $redirect;

    $db      = \Config\Database::connect();
    $builder = $db->table('employe')
        ->select('employe.Nom_Emp, employe.Prenom_Emp, employe.Email_Emp,
                  employe.Telephone_Emp, employe.Adresse_Emp,
                  employe.Sexe_Emp, employe.DateNaissance_Emp,
                  employe.DateEmbauche_Emp, employe.Disponibilite_Emp,
                  direction.Nom_Dir, grade.Libelle_Grd, profil.Libelle_Pfl')
        ->join('direction', 'direction.id_Dir = employe.id_Dir', 'left')
        ->join('grade',     'grade.id_Grd = employe.id_Grd',     'left')
        ->join('profil',    'profil.id_Pfl = employe.id_Pfl',    'left');

    $ids = $this->request->getGet('ids');
    if (!empty($ids)) {
        $idList = array_filter(explode(',', $ids), fn($v) => is_numeric($v));
        if (!empty($idList)) $builder->whereIn('employe.id_Emp', $idList);
    }

    $employes = $builder->orderBy('employe.Nom_Emp', 'ASC')->get()->getResultArray();

    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    $sheet       = $spreadsheet->getActiveSheet();
    $sheet->setTitle('Employes');

    // Style entete
    $headerStyle = [
        'font'      => ['bold' => true, 'color' => ['argb' => 'FF111111'], 'size' => 10],
        'fill'      => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'FFF5A623']],
        'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
        'borders'   => ['bottom' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                     'color'       => ['argb' => 'FFD4891A']]],
    ];

    // Entetes colonnes
    $headers = [
        'A' => 'Nom',        'B' => 'Prenom',       'C' => 'Email',
        'D' => 'Telephone',  'E' => 'Adresse',       'F' => 'Sexe',
        'G' => 'Naissance',  'H' => 'Embauche',      'I' => 'Disponibilite',
        'J' => 'Direction',  'K' => 'Grade',          'L' => 'Profil',
    ];

    foreach ($headers as $col => $label) {
        $sheet->setCellValue($col . '1', $label);
        $sheet->getStyle($col . '1')->applyFromArray($headerStyle);
        $sheet->getColumnDimension($col)->setAutoSize(true);
    }

    // Donnees
    $row = 2;
    foreach ($employes as $emp) {
        $sheet->setCellValue('A' . $row, $emp['Nom_Emp']);
        $sheet->setCellValue('B' . $row, $emp['Prenom_Emp']);
        $sheet->setCellValue('C' . $row, $emp['Email_Emp']);
        $sheet->setCellValue('D' . $row, $emp['Telephone_Emp']);
        $sheet->setCellValue('E' . $row, $emp['Adresse_Emp']);
        $sheet->setCellValue('F' . $row, (int)$emp['Sexe_Emp'] === 1 ? 'Homme' : 'Femme');
        $sheet->setCellValue('G' . $row, !empty($emp['DateNaissance_Emp']) ? date('d/m/Y', strtotime($emp['DateNaissance_Emp'])) : '');
        $sheet->setCellValue('H' . $row, !empty($emp['DateEmbauche_Emp'])  ? date('d/m/Y', strtotime($emp['DateEmbauche_Emp']))  : '');
        $sheet->setCellValue('I' . $row, (int)$emp['Disponibilite_Emp'] === 1 ? 'Disponible' : 'Absent');
        $sheet->setCellValue('J' . $row, $emp['Nom_Dir']     ?? '');
        $sheet->setCellValue('K' . $row, $emp['Libelle_Grd'] ?? '');
        $sheet->setCellValue('L' . $row, $emp['Libelle_Pfl'] ?? '');

        // Alterner couleur de ligne
        if ($row % 2 === 0) {
            $sheet->getStyle('A'.$row.':L'.$row)->getFill()
                  ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                  ->getStartColor()->setARGB('FF1E1E1E');
        }
        $row++;
    }

    // En-tete du fichier
    $spreadsheet->getProperties()
        ->setCreator('ANSTAT RH')
        ->setTitle('Liste des employes')
        ->setDescription('Export genere le ' . date('d/m/Y H:i'));

    $filename = 'employes_' . date('Ymd_His') . '.xlsx';

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Cache-Control: max-age=0');

    $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;
}

// ===== MODELE IMPORT =====
public function modele()
{
    $redirect = $this->checkAccess();
    if ($redirect) return $redirect;

    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    $sheet       = $spreadsheet->getActiveSheet();
    $sheet->setTitle('Employes');

    $headerStyle = [
        'font' => ['bold' => true, 'color' => ['argb' => 'FF111111']],
        'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                   'startColor' => ['argb' => 'FFF5A623']],
        'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
    ];

    $headers = ['Nom','Prenom','Email','Telephone','Adresse',
                'Sexe (0=Femme, 1=Homme)','Date Naissance (YYYY-MM-DD)',
                'Date Embauche (YYYY-MM-DD)','Direction','Grade','Profil','Mot de passe'];

    foreach ($headers as $i => $h) {
        $col = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($i + 1);
        $sheet->setCellValue($col . '1', $h);
        $sheet->getStyle($col . '1')->applyFromArray($headerStyle);
        $sheet->getColumnDimension($col)->setAutoSize(true);
    }

    // Ligne exemple
    $exemple = ['KOUASSI','Jean','jean.kouassi@anstat.ci','0701020304',
                'Abidjan Plateau','1','1990-05-15','2020-01-10',
                'Direction Generale','Cadre','RH','password123'];

    foreach ($exemple as $i => $val) {
        $col = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($i + 1);
        $sheet->setCellValue($col . '2', $val);
        $sheet->getStyle($col . '2')->getFont()->setItalic(true);
        $sheet->getStyle($col . '2')->getFont()->getColor()->setARGB('FF888888');
    }

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="modele_import_employes.xlsx"');
    header('Cache-Control: max-age=0');

    $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;
}

// ===== IMPORT =====
public function import()
{
    $redirect = $this->checkAccess();
    if ($redirect) return $redirect;

    $fichier = $this->request->getFile('fichier_import');

    if (!$fichier || !$fichier->isValid()) {
        return redirect()->to('employe')->with('error', 'Fichier invalide ou absent.');
    }

    $ext = strtolower($fichier->getClientExtension());
    if (!in_array($ext, ['xlsx', 'xls', 'csv'])) {
        return redirect()->to('employe')->with('error', 'Format non accepte. Utilisez .xlsx, .xls ou .csv.');
    }

    // Taille max 5Mo
    if ($fichier->getSize() > 5 * 1024 * 1024) {
        return redirect()->to('employe')->with('error', 'Fichier trop volumineux (max 5 Mo).');
    }

    $tmpPath = $fichier->getTempName();
    $errors  = [];
    $inserts = 0;
    $db      = \Config\Database::connect();

    try {
        if ($ext === 'csv') {
            // Lecture CSV
            $handle = fopen($tmpPath, 'r');
            $rowNum = 0;
            while (($line = fgetcsv($handle, 1000, ';')) !== false) {
                $rowNum++;
                if ($rowNum === 1) continue; // sauter l'entete
                $result = $this->_importRow($line, $rowNum, $db, $errors);
                if ($result) $inserts++;
            }
            fclose($handle);
        } else {
            // Lecture Excel
            $reader      = \PhpOffice\PhpSpreadsheet\IOFactory::createReaderForFile($tmpPath);
            $spreadsheet = $reader->load($tmpPath);
            $rows        = $spreadsheet->getActiveSheet()->toArray();

            foreach ($rows as $rowNum => $line) {
                if ($rowNum === 0) continue; // sauter l'entete
                if (empty(array_filter($line))) continue; // ligne vide
                $result = $this->_importRow($line, $rowNum + 1, $db, $errors);
                if ($result) $inserts++;
            }
        }
    } catch (\Exception $e) {
        return redirect()->to('employe')->with('error', 'Erreur de lecture du fichier : ' . $e->getMessage());
    }

    $msg = $inserts . ' employe(s) importe(s) avec succes.';
    if (!empty($errors)) {
        return redirect()->to('employe')
            ->with('success', $msg)
            ->with('import_errors', $errors);
    }

    return redirect()->to('employe')->with('success', $msg);
}

// Traiter une ligne d'import
private function _importRow(array $line, int $rowNum, $db, array &$errors): bool
{
    // Colonnes : 0=Nom 1=Prenom 2=Email 3=Tel 4=Adresse 5=Sexe 6=DateNais 7=DateEmb 8=Direction 9=Grade 10=Profil 11=Password
    $nom      = trim($line[0] ?? '');
    $prenom   = trim($line[1] ?? '');
    $email    = trim($line[2] ?? '');
    $tel      = trim($line[3] ?? '');
    $adresse  = trim($line[4] ?? '');
    $sexe     = (int)($line[5] ?? 0);
    $dateNais = trim($line[6] ?? '');
    $dateEmb  = trim($line[7] ?? '');
    $dirLib   = trim($line[8] ?? '');
    $grdLib   = trim($line[9] ?? '');
    $pflLib   = trim($line[10] ?? '');
    $password = trim($line[11] ?? 'password123');

    if (empty($nom) || empty($prenom) || empty($email)) {
        $errors[] = "Ligne $rowNum : Nom, Prenom et Email sont obligatoires.";
        return false;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Ligne $rowNum : Email invalide ($email).";
        return false;
    }

    // Verifier doublon email
    if ($db->table('employe')->where('Email_Emp', $email)->countAllResults() > 0) {
        $errors[] = "Ligne $rowNum : Email deja utilise ($email), ligne ignoree.";
        return false;
    }

    // Resoudre direction
    $dir = $db->table('direction')->where('Nom_Dir', $dirLib)->get()->getRowArray();
    $idDir = $dir ? $dir['id_Dir'] : null;

    if (!$idDir) {
        $errors[] = "Ligne $rowNum : Direction introuvable ($dirLib), employe insere sans direction.";
    }

    // Resoudre grade
    $grd = $db->table('grade')->where('Libelle_Grd', $grdLib)->get()->getRowArray();
    $idGrd = $grd ? $grd['id_Grd'] : null;

    // Resoudre profil
    $pfl = $db->table('profil')->where('Libelle_Pfl', $pflLib)->get()->getRowArray();
    $idPfl = $pfl ? $pfl['id_Pfl'] : 3; // Employe par defaut

    $db->table('employe')->insert([
        'Nom_Emp'            => $nom,
        'Prenom_Emp'         => $prenom,
        'Email_Emp'          => $email,
        'Telephone_Emp'      => $tel,
        'Adresse_Emp'        => $adresse,
        'Sexe_Emp'           => $sexe,
        'DateNaissance_Emp'  => $dateNais ?: null,
        'DateEmbauche_Emp'   => $dateEmb  ?: null,
        'Disponibilite_Emp'  => 1,
        'id_Dir'             => $idDir,
        'id_Grd'             => $idGrd,
        'id_Pfl'             => $idPfl,
        'Password_Emp'       => password_hash($password, PASSWORD_DEFAULT),
    ]);

    $idEmp = $db->insertID();

    // Creer solde conge initial
    if ($idEmp) {
        $types = $db->table('type_conge')->get()->getResultArray();
        foreach ($types as $type) {
            $db->table('solde_conge')->insert([
                'id_Emp'       => $idEmp,
                'id_TypeConge' => $type['id_TypeConge'],
                'Solde'        => $type['NbJours_TypeConge'] ?? 0,
                'Annee'        => date('Y'),
            ]);
        }
    }

    return true;
}
}