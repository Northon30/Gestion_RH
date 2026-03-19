<?php

namespace App\Controllers;

use App\Models\EmployeModel;
use App\Models\DirectionModel;
use App\Models\GradeModel;
use App\Models\ProfilModel;
use App\Models\ActivityLogModel;

class EmployeController extends BaseController
{
    protected $model;
    protected $log;

    public function __construct()
    {
        $this->model = new EmployeModel();
        $this->log   = new ActivityLogModel();
    }

    private function idEmp(): int { return (int) session()->get('id_Emp'); }
    private function idPfl(): int { return (int) session()->get('id_Pfl'); }

    // Accès réservé au RH uniquement (create, edit, delete, exports…)
    private function checkAccess()
    {
        if ($this->idPfl() !== 1) {
            return redirect()->to('dashboard')->with('error', 'Accès non autorisé.');
        }
        return null;
    }

    // ══════════════════════════════════════════════════════════
    // INDEX — RH : tous les employés / Chef : sa direction
    // ══════════════════════════════════════════════════════════
    public function index()
    {
        $idPfl = $this->idPfl();

        // Employé normal : pas d'accès
        if ($idPfl === 3) {
            return redirect()->to('dashboard')->with('error', 'Accès non autorisé.');
        }

        $db      = \Config\Database::connect();
        $builder = $db->table('employe')
            ->select('employe.*, direction.Nom_Dir, grade.Libelle_Grd, profil.Libelle_Pfl')
            ->join('direction', 'direction.id_Dir = employe.id_Dir', 'left')
            ->join('grade',     'grade.id_Grd = employe.id_Grd',     'left')
            ->join('profil',    'profil.id_Pfl = employe.id_Pfl',    'left');

        // Chef : filtrer par sa direction
        if ($idPfl === 2) {
            $chef = $this->model->find($this->idEmp());
            $builder->where('employe.id_Dir', $chef['id_Dir']);
        }

        $employes = $builder->orderBy('employe.Nom_Emp', 'ASC')->get()->getResultArray();

        $data = [
            'title'    => $idPfl === 2 ? 'Employés de ma direction' : 'Employés',
            'employes' => $employes,
            'idPfl'    => $idPfl,
        ];

        // Filtres disponibles uniquement pour le RH
        if ($idPfl === 1) {
            $data['directions'] = (new DirectionModel())->orderBy('Nom_Dir')->findAll();
            $data['grades']     = (new GradeModel())->orderBy('Libelle_Grd')->findAll();
            $data['profils']    = (new ProfilModel())->findAll();
        }

        // Vue selon le profil
        $view = $idPfl === 2 ? 'chef/employe/index' : 'rh/employe/index';

        return view($view, $data);
    }

    // ══════════════════════════════════════════════════════════
    // SHOW — RH : tous / Chef : sa direction uniquement
    // ══════════════════════════════════════════════════════════
    public function show($id)
    {
        $idPfl = $this->idPfl();

        if ($idPfl === 3) {
            return redirect()->to('dashboard')->with('error', 'Accès non autorisé.');
        }

        $db = \Config\Database::connect();

        $employe = $db->table('employe')
            ->select('employe.*, direction.Nom_Dir, grade.Libelle_Grd, profil.Libelle_Pfl')
            ->join('direction', 'direction.id_Dir = employe.id_Dir', 'left')
            ->join('grade',     'grade.id_Grd = employe.id_Grd',    'left')
            ->join('profil',    'profil.id_Pfl = employe.id_Pfl',   'left')
            ->where('employe.id_Emp', $id)
            ->get()->getRowArray();

        if (!$employe) {
            return redirect()->to('employe')->with('error', 'Employé introuvable.');
        }

        // Chef : vérifier que l'employé est dans sa direction
        if ($idPfl === 2) {
            $chef = $this->model->find($this->idEmp());
            if ((int) $employe['id_Dir'] !== (int) $chef['id_Dir']) {
                return redirect()->to('employe')->with('error', 'Accès refusé.');
            }
        }

        $soldes = $db->table('solde_conge')
            ->where('id_Emp', $id)
            ->orderBy('Annee_Sld', 'DESC')
            ->get()->getResultArray();

        $conges = $db->table('conge')
            ->select('conge.*, type_conge.Libelle_Tcg')
            ->join('type_conge', 'type_conge.id_Tcg = conge.id_Tcg', 'left')
            ->where('conge.id_Emp', $id)
            ->orderBy('conge.DateDebut_Cge', 'DESC')
            ->get()->getResultArray();

        $absences = $db->table('absence')
            ->select('absence.*, type_absence.Libelle_TAbs, piece_justificative.CheminFichier_PJ')
            ->join('type_absence',        'type_absence.id_TAbs = absence.id_TAbs',      'left')
            ->join('piece_justificative', 'piece_justificative.id_Abs = absence.id_Abs', 'left')
            ->where('absence.id_Emp', $id)
            ->orderBy('absence.DateDebut_Abs', 'DESC')
            ->get()->getResultArray();

        $formations = $db->table('s_inscrire')
            ->select('s_inscrire.Stt_Ins, s_inscrire.Dte_Ins,
                      s_inscrire.id_Frm,
                      formation.Titre_Frm, formation.Description_Frm,
                      formation.DateDebut_Frm, formation.DateFin_Frm,
                      formation.Lieu_Frm, formation.Formateur_Frm,
                      formation.Statut_Frm')
            ->join('formation', 'formation.id_Frm = s_inscrire.id_Frm', 'left')
            ->where('s_inscrire.id_Emp', $id)
            ->whereNotIn('s_inscrire.Stt_Ins', ['annule'])
            ->orderBy('formation.DateDebut_Frm', 'DESC')
            ->get()->getResultArray();

        $competences = $db->table('obtenir')
            ->select('obtenir.id_Obt, obtenir.Niveau_Obt, obtenir.Dte_Obt,
                      obtenir.id_Cmp, obtenir.id_Frm,
                      competence.Libelle_Cmp,
                      formation.Titre_Frm')
            ->join('competence', 'competence.id_Cmp = obtenir.id_Cmp', 'left')
            ->join('formation',  'formation.id_Frm = obtenir.id_Frm',  'left')
            ->where('obtenir.id_Emp', $id)
            ->where('obtenir.id_Emp IS NOT NULL')
            ->orderBy('competence.Libelle_Cmp')
            ->get()->getResultArray();

        $evenements = $db->table('participer')
            ->select('evenement.id_Evt, evenement.Titre_Evt, evenement.Description_Evt,
                      evenement.Date_Evt, type_evenement.Libelle_Tev')
            ->join('evenement',      'evenement.id_Evt = participer.id_Evt',     'left')
            ->join('type_evenement', 'type_evenement.id_Tev = evenement.id_Tev', 'left')
            ->where('participer.id_Emp', $id)
            ->orderBy('evenement.Date_Evt', 'DESC')
            ->get()->getResultArray();

        $view = $idPfl === 2 ? 'chef/employe/show' : 'rh/employe/show';

        return view($view, [
            'title'       => $employe['Nom_Emp'] . ' ' . $employe['Prenom_Emp'],
            'employe'     => $employe,
            'soldes'      => $soldes,
            'conges'      => $conges,
            'absences'    => $absences,
            'formations'  => $formations,
            'competences' => $competences,
            'evenements'  => $evenements,
            'idPfl'       => $idPfl,
        ]);
    }

    // ══════════════════════════════════════════════════════════
    // CREATE — RH uniquement
    // ══════════════════════════════════════════════════════════
    public function create()
    {
        $redirect = $this->checkAccess();
        if ($redirect) return $redirect;

        return view('rh/employe/create', [
            'title'      => 'Nouvel Employé',
            'directions' => (new DirectionModel())->orderBy('Nom_Dir')->findAll(),
            'grades'     => (new GradeModel())->orderBy('Libelle_Grd')->findAll(),
            'profils'    => (new ProfilModel())->findAll(),
        ]);
    }

    // ══════════════════════════════════════════════════════════
    // STORE — RH uniquement
    // ══════════════════════════════════════════════════════════
    public function store()
    {
        $redirect = $this->checkAccess();
        if ($redirect) return $redirect;

        $matricule = trim($this->request->getPost('Matricule_Emp') ?? '');

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

        if ($matricule !== '') {
            $rules['Matricule_Emp'] = 'is_unique[employe.Matricule_Emp]|max_length[50]';
        }

        if (!$this->validate($rules)) {
            return view('rh/employe/create', [
                'title'      => 'Nouvel Employé',
                'errors'     => $this->validator->getErrors(),
                'directions' => (new DirectionModel())->orderBy('Nom_Dir')->findAll(),
                'grades'     => (new GradeModel())->orderBy('Libelle_Grd')->findAll(),
                'profils'    => (new ProfilModel())->findAll(),
            ]);
        }

        $empData = [
            'Matricule_Emp'     => $matricule ?: null,
            'Nom_Emp'           => $this->request->getPost('Nom_Emp'),
            'Prenom_Emp'        => $this->request->getPost('Prenom_Emp'),
            'Email_Emp'         => $this->request->getPost('Email_Emp'),
            'Telephone_Emp'     => $this->request->getPost('Telephone_Emp'),
            'Adresse_Emp'       => $this->request->getPost('Adresse_Emp'),
            'Sexe_Emp'          => (int) $this->request->getPost('Sexe_Emp'),
            'DateNaissance_Emp' => $this->request->getPost('DateNaissance_Emp'),
            'DateEmbauche_Emp'  => $this->request->getPost('DateEmbauche_Emp') ?: null,
            'Disponibilite_Emp' => (int) ($this->request->getPost('Disponibilite_Emp') ?? 1),
            'id_Dir'            => $this->request->getPost('id_Dir'),
            'id_Grd'            => $this->request->getPost('id_Grd'),
            'id_Pfl'            => $this->request->getPost('id_Pfl'),
            'Password_Emp'      => password_hash(
                $this->request->getPost('Password_Emp'),
                PASSWORD_DEFAULT
            ),
        ];

        $id = $this->model->insert($empData);

        if (!$id) {
            return redirect()->back()->withInput()
                             ->with('error', 'Erreur lors de la création de l\'employé.');
        }

        (new \App\Models\SoldeCongeModel())->insert([
            'Annee_Sld'        => date('Y'),
            'NbJoursDroit_Sld' => 30,
            'NbJoursPris_Sld'  => 0,
            'id_Emp'           => $id,
        ]);

        (new \App\Models\AttribuerModel())->insert([
            'Dte_Aff' => date('Y-m-d'),
            'id_Emp'  => $id,
            'id_Grd'  => $empData['id_Grd'],
        ]);

        $this->log->insert([
            'Action_Log'      => 'CREATE',
            'Module_Log'      => 'Employe',
            'Description_Log' => 'Création employé : '
                               . $empData['Nom_Emp'] . ' ' . $empData['Prenom_Emp']
                               . (!empty($empData['Matricule_Emp']) ? ' (' . $empData['Matricule_Emp'] . ')' : ''),
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => session()->get('id_Emp'),
        ]);

        if ($this->request->getPost('action') === 'new') {
            return redirect()->to('employe/create')
                             ->with('success', 'Employé créé. Vous pouvez en saisir un autre.');
        }

        return redirect()->to('employe/show/' . $id)
                         ->with('success', 'Employé créé avec succès.');
    }

    // ══════════════════════════════════════════════════════════
    // EDIT — RH uniquement
    // ══════════════════════════════════════════════════════════
    public function edit($id)
    {
        $redirect = $this->checkAccess();
        if ($redirect) return $redirect;

        $db      = \Config\Database::connect();
        $employe = $db->table('employe')
            ->select('employe.*, direction.Nom_Dir, grade.Libelle_Grd, profil.Libelle_Pfl')
            ->join('direction', 'direction.id_Dir = employe.id_Dir', 'left')
            ->join('grade',     'grade.id_Grd = employe.id_Grd',     'left')
            ->join('profil',    'profil.id_Pfl = employe.id_Pfl',    'left')
            ->where('employe.id_Emp', $id)
            ->get()->getRowArray();

        if (!$employe) {
            return redirect()->to('employe')->with('error', 'Employé introuvable.');
        }

        return view('rh/employe/edit', [
            'title'      => 'Modifier ' . $employe['Nom_Emp'] . ' ' . $employe['Prenom_Emp'],
            'employe'    => $employe,
            'directions' => (new DirectionModel())->orderBy('Nom_Dir')->findAll(),
            'grades'     => (new GradeModel())->orderBy('Libelle_Grd')->findAll(),
            'profils'    => (new ProfilModel())->findAll(),
        ]);
    }

    // ══════════════════════════════════════════════════════════
    // UPDATE — RH uniquement
    // ══════════════════════════════════════════════════════════
    public function update($id)
    {
        $redirect = $this->checkAccess();
        if ($redirect) return $redirect;

        $db      = \Config\Database::connect();
        $employe = $db->table('employe')->where('id_Emp', $id)->get()->getRowArray();

        if (!$employe) {
            return redirect()->to('employe')->with('error', 'Employé introuvable.');
        }

        $matricule = trim($this->request->getPost('Matricule_Emp') ?? '');

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

        if ($matricule !== '') {
            $rules['Matricule_Emp'] = "is_unique[employe.Matricule_Emp,id_Emp,{$id}]|max_length[50]";
        }

        $password = $this->request->getPost('Password_Emp');
        if (!empty($password)) {
            $rules['Password_Emp'] = 'min_length[6]';
        }

        if (!$this->validate($rules)) {
            $employe = $db->table('employe')
                ->select('employe.*, direction.Nom_Dir, grade.Libelle_Grd, profil.Libelle_Pfl')
                ->join('direction', 'direction.id_Dir = employe.id_Dir', 'left')
                ->join('grade',     'grade.id_Grd = employe.id_Grd',     'left')
                ->join('profil',    'profil.id_Pfl = employe.id_Pfl',    'left')
                ->where('employe.id_Emp', $id)
                ->get()->getRowArray();

            return view('rh/employe/edit', [
                'title'      => 'Modifier ' . $employe['Nom_Emp'] . ' ' . $employe['Prenom_Emp'],
                'errors'     => $this->validator->getErrors(),
                'employe'    => $employe,
                'directions' => (new DirectionModel())->orderBy('Nom_Dir')->findAll(),
                'grades'     => (new GradeModel())->orderBy('Libelle_Grd')->findAll(),
                'profils'    => (new ProfilModel())->findAll(),
            ]);
        }

        $nouveauGrd = (int) $this->request->getPost('id_Grd');
        $ancienGrd  = (int) $employe['id_Grd'];

        $empData = [
            'Matricule_Emp'     => $matricule ?: null,
            'Nom_Emp'           => $this->request->getPost('Nom_Emp'),
            'Prenom_Emp'        => $this->request->getPost('Prenom_Emp'),
            'Email_Emp'         => $this->request->getPost('Email_Emp'),
            'Telephone_Emp'     => $this->request->getPost('Telephone_Emp'),
            'Adresse_Emp'       => $this->request->getPost('Adresse_Emp'),
            'Sexe_Emp'          => (int) $this->request->getPost('Sexe_Emp'),
            'DateNaissance_Emp' => $this->request->getPost('DateNaissance_Emp'),
            'DateEmbauche_Emp'  => $this->request->getPost('DateEmbauche_Emp') ?: null,
            'Disponibilite_Emp' => (int) ($this->request->getPost('Disponibilite_Emp') ?? 1),
            'id_Dir'            => $this->request->getPost('id_Dir'),
            'id_Grd'            => $nouveauGrd,
            'id_Pfl'            => $this->request->getPost('id_Pfl'),
        ];

        if (!empty($password)) {
            $empData['Password_Emp'] = password_hash($password, PASSWORD_DEFAULT);
        }

        if ($nouveauGrd !== $ancienGrd) {
            (new \App\Models\AttribuerModel())->insert([
                'Dte_Aff' => date('Y-m-d'),
                'id_Emp'  => $id,
                'id_Grd'  => $nouveauGrd,
            ]);
        }

        $this->model->update($id, $empData);

        $this->log->insert([
            'Action_Log'      => 'UPDATE',
            'Module_Log'      => 'Employe',
            'Description_Log' => 'Modification employé ID : ' . $id
                               . ' (' . $empData['Nom_Emp'] . ' ' . $empData['Prenom_Emp'] . ')'
                               . ($nouveauGrd !== $ancienGrd ? ' — changement de grade' : ''),
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => session()->get('id_Emp'),
        ]);

        return redirect()->to('employe/show/' . $id)
                         ->with('success', 'Employé modifié avec succès.');
    }

    // ══════════════════════════════════════════════════════════
    // DELETE — RH uniquement
    // ══════════════════════════════════════════════════════════
    public function delete($id)
    {
        $redirect = $this->checkAccess();
        if ($redirect) return $redirect;

        $employe = $this->model->find($id);

        if (!$employe) {
            return redirect()->to('employe')->with('error', 'Employé introuvable.');
        }

        if ((int) $id === $this->idEmp()) {
            return redirect()->to('employe')
                             ->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');
        }

        $this->model->delete($id);

        $this->log->insert([
            'Action_Log'      => 'DELETE',
            'Module_Log'      => 'Employe',
            'Description_Log' => 'Suppression employé : '
                               . $employe['Nom_Emp'] . ' ' . $employe['Prenom_Emp']
                               . (!empty($employe['Matricule_Emp']) ? ' (' . $employe['Matricule_Emp'] . ')' : ''),
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => session()->get('id_Emp'),
        ]);

        return redirect()->to('employe')->with('success', 'Employé supprimé avec succès.');
    }

    // ══════════════════════════════════════════════════════════
    // EXPORT CSV — RH uniquement
    // ══════════════════════════════════════════════════════════
    public function exportCsv()
    {
        $redirect = $this->checkAccess();
        if ($redirect) return $redirect;

        $db      = \Config\Database::connect();
        $builder = $db->table('employe')
            ->select('employe.id_Emp, employe.Matricule_Emp,
                      employe.Nom_Emp, employe.Prenom_Emp,
                      employe.Email_Emp, employe.Telephone_Emp, employe.Adresse_Emp,
                      employe.Sexe_Emp, employe.DateNaissance_Emp,
                      employe.DateEmbauche_Emp, employe.Disponibilite_Emp,
                      direction.Nom_Dir, grade.Libelle_Grd, profil.Libelle_Pfl')
            ->join('direction', 'direction.id_Dir = employe.id_Dir', 'left')
            ->join('grade',     'grade.id_Grd = employe.id_Grd',     'left')
            ->join('profil',    'profil.id_Pfl = employe.id_Pfl',    'left');

        $ids = $this->request->getGet('ids');
        if (!empty($ids)) {
            $idList = array_filter(explode(',', $ids), fn($v) => is_numeric(trim($v)));
            if (!empty($idList)) $builder->whereIn('employe.id_Emp', $idList);
        }

        $employes = $builder->orderBy('employe.Nom_Emp', 'ASC')->get()->getResultArray();
        $filename = 'employes_' . date('Ymd_His') . '.csv';

        header('Content-Type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: no-cache, no-store, must-revalidate');

        $output = fopen('php://output', 'w');
        fputs($output, "\xEF\xBB\xBF");

        fputcsv($output, [
            'Matricule', 'Nom', 'Prénom', 'Email', 'Téléphone', 'Adresse',
            'Sexe', 'Date Naissance', 'Date Embauche',
            'Disponibilité', 'Direction', 'Grade', 'Profil',
        ], ';');

        foreach ($employes as $emp) {
            fputcsv($output, [
                $emp['Matricule_Emp'] ?? '',
                $emp['Nom_Emp'],
                $emp['Prenom_Emp'],
                $emp['Email_Emp'],
                $emp['Telephone_Emp'],
                $emp['Adresse_Emp'],
                (int) $emp['Sexe_Emp'] === 1 ? 'Homme' : 'Femme',
                !empty($emp['DateNaissance_Emp']) ? date('d/m/Y', strtotime($emp['DateNaissance_Emp'])) : '',
                !empty($emp['DateEmbauche_Emp'])  ? date('d/m/Y', strtotime($emp['DateEmbauche_Emp']))  : '',
                (int) $emp['Disponibilite_Emp'] === 1 ? 'Disponible' : 'Absent',
                $emp['Nom_Dir']     ?? '',
                $emp['Libelle_Grd'] ?? '',
                $emp['Libelle_Pfl'] ?? '',
            ], ';');
        }

        fclose($output);
        exit;
    }

    // ══════════════════════════════════════════════════════════
    // EXPORT EXCEL — RH uniquement
    // ══════════════════════════════════════════════════════════
    public function exportExcel()
    {
        $redirect = $this->checkAccess();
        if ($redirect) return $redirect;

        $db      = \Config\Database::connect();
        $builder = $db->table('employe')
            ->select('employe.id_Emp, employe.Matricule_Emp,
                      employe.Nom_Emp, employe.Prenom_Emp,
                      employe.Email_Emp, employe.Telephone_Emp, employe.Adresse_Emp,
                      employe.Sexe_Emp, employe.DateNaissance_Emp,
                      employe.DateEmbauche_Emp, employe.Disponibilite_Emp,
                      direction.Nom_Dir, grade.Libelle_Grd, profil.Libelle_Pfl')
            ->join('direction', 'direction.id_Dir = employe.id_Dir', 'left')
            ->join('grade',     'grade.id_Grd = employe.id_Grd',     'left')
            ->join('profil',    'profil.id_Pfl = employe.id_Pfl',    'left');

        $ids = $this->request->getGet('ids');
        if (!empty($ids)) {
            $idList = array_filter(explode(',', $ids), fn($v) => is_numeric(trim($v)));
            if (!empty($idList)) $builder->whereIn('employe.id_Emp', $idList);
        }

        $employes    = $builder->orderBy('employe.Nom_Emp', 'ASC')->get()->getResultArray();
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet       = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Employés');

        $headerStyle = [
            'font'      => ['bold' => true, 'color' => ['argb' => 'FF111111'], 'size' => 10],
            'fill'      => ['fillType'   => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                            'startColor' => ['argb' => 'FFF5A623']],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
            'borders'   => ['bottom' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                'color'       => ['argb' => 'FFD4891A'],
            ]],
        ];

        $headers = [
            'A' => 'Matricule',     'B' => 'Nom',        'C' => 'Prénom',
            'D' => 'Email',         'E' => 'Téléphone',  'F' => 'Adresse',
            'G' => 'Sexe',          'H' => 'Naissance',  'I' => 'Embauche',
            'J' => 'Disponibilité', 'K' => 'Direction',  'L' => 'Grade',
            'M' => 'Profil',
        ];

        foreach ($headers as $col => $label) {
            $sheet->setCellValue($col . '1', $label);
            $sheet->getStyle($col . '1')->applyFromArray($headerStyle);
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $row = 2;
        foreach ($employes as $emp) {
            $sheet->setCellValue('A' . $row, $emp['Matricule_Emp'] ?? '');
            $sheet->setCellValue('B' . $row, $emp['Nom_Emp']);
            $sheet->setCellValue('C' . $row, $emp['Prenom_Emp']);
            $sheet->setCellValue('D' . $row, $emp['Email_Emp']);
            $sheet->setCellValue('E' . $row, $emp['Telephone_Emp']);
            $sheet->setCellValue('F' . $row, $emp['Adresse_Emp']);
            $sheet->setCellValue('G' . $row, (int) $emp['Sexe_Emp'] === 1 ? 'Homme' : 'Femme');
            $sheet->setCellValue('H' . $row, !empty($emp['DateNaissance_Emp'])
                ? date('d/m/Y', strtotime($emp['DateNaissance_Emp'])) : '');
            $sheet->setCellValue('I' . $row, !empty($emp['DateEmbauche_Emp'])
                ? date('d/m/Y', strtotime($emp['DateEmbauche_Emp'])) : '');
            $sheet->setCellValue('J' . $row, (int) $emp['Disponibilite_Emp'] === 1 ? 'Disponible' : 'Absent');
            $sheet->setCellValue('K' . $row, $emp['Nom_Dir']     ?? '');
            $sheet->setCellValue('L' . $row, $emp['Libelle_Grd'] ?? '');
            $sheet->setCellValue('M' . $row, $emp['Libelle_Pfl'] ?? '');

            if ($row % 2 === 0) {
                $sheet->getStyle('A' . $row . ':M' . $row)
                      ->getFill()
                      ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                      ->getStartColor()->setARGB('FFF9F9F9');
            }
            $row++;
        }

        $spreadsheet->getProperties()
            ->setCreator('ANSTAT RH')
            ->setTitle('Liste des employés')
            ->setDescription('Export généré le ' . date('d/m/Y H:i'));

        $filename = 'employes_' . date('Ymd_His') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    // ══════════════════════════════════════════════════════════
    // MODÈLE IMPORT — RH uniquement
    // ══════════════════════════════════════════════════════════
    public function modele()
    {
        $redirect = $this->checkAccess();
        if ($redirect) return $redirect;

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet       = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Employés');

        $headerStyle = [
            'font'      => ['bold' => true, 'color' => ['argb' => 'FF111111']],
            'fill'      => ['fillType'   => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                            'startColor' => ['argb' => 'FFF5A623']],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
        ];

        $headers = [
            'Matricule', 'Nom', 'Prénom', 'Email', 'Téléphone', 'Adresse',
            'Sexe (0=Femme, 1=Homme)', 'Date Naissance (YYYY-MM-DD)',
            'Date Embauche (YYYY-MM-DD)', 'Direction', 'Grade', 'Profil', 'Mot de passe',
        ];

        foreach ($headers as $i => $h) {
            $col = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($i + 1);
            $sheet->setCellValue($col . '1', $h);
            $sheet->getStyle($col . '1')->applyFromArray($headerStyle);
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $exemple = [
            'ANST-2024-001', 'KOUASSI', 'Jean', 'jean.kouassi@anstat.ci', '0701020304',
            'Abidjan Plateau', '1', '1990-05-15', '2020-01-10',
            'Direction Générale', 'Cadre', 'Employé', 'password123',
        ];

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

    // ══════════════════════════════════════════════════════════
    // IMPORT — RH uniquement
    // ══════════════════════════════════════════════════════════
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
            return redirect()->to('employe')
                             ->with('error', 'Format non accepté. Utilisez .xlsx, .xls ou .csv.');
        }

        if ($fichier->getSize() > 5 * 1024 * 1024) {
            return redirect()->to('employe')
                             ->with('error', 'Fichier trop volumineux (max 5 Mo).');
        }

        $tmpPath = $fichier->getTempName();
        $errors  = [];
        $inserts = 0;
        $db      = \Config\Database::connect();

        try {
            if ($ext === 'csv') {
                $handle = fopen($tmpPath, 'r');
                $rowNum = 0;
                while (($line = fgetcsv($handle, 1000, ';')) !== false) {
                    $rowNum++;
                    if ($rowNum === 1) continue;
                    if ($this->_importRow($line, $rowNum, $db, $errors)) $inserts++;
                }
                fclose($handle);
            } else {
                $reader      = \PhpOffice\PhpSpreadsheet\IOFactory::createReaderForFile($tmpPath);
                $spreadsheet = $reader->load($tmpPath);
                $rows        = $spreadsheet->getActiveSheet()->toArray();

                foreach ($rows as $rowNum => $line) {
                    if ($rowNum === 0) continue;
                    if (empty(array_filter($line))) continue;
                    if ($this->_importRow($line, $rowNum + 1, $db, $errors)) $inserts++;
                }
            }
        } catch (\Exception $e) {
            return redirect()->to('employe')
                             ->with('error', 'Erreur de lecture du fichier : ' . $e->getMessage());
        }

        $this->log->insert([
            'Action_Log'      => 'IMPORT',
            'Module_Log'      => 'Employe',
            'Description_Log' => 'Import employés : ' . $inserts . ' créé(s), '
                               . count($errors) . ' erreur(s)',
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => session()->get('id_Emp'),
        ]);

        $msg = $inserts . ' employé(s) importé(s) avec succès.';

        if (!empty($errors)) {
            return redirect()->to('employe')
                ->with('success', $msg)
                ->with('import_errors', $errors);
        }

        return redirect()->to('employe')->with('success', $msg);
    }

    // ══════════════════════════════════════════════════════════
    // IMPORT ROW — traitement ligne par ligne (RH uniquement)
    // ══════════════════════════════════════════════════════════
    private function _importRow(array $line, int $rowNum, $db, array &$errors): bool
    {
        $matricule = trim($line[0]  ?? '');
        $nom       = trim($line[1]  ?? '');
        $prenom    = trim($line[2]  ?? '');
        $email     = trim($line[3]  ?? '');
        $tel       = trim($line[4]  ?? '');
        $adresse   = trim($line[5]  ?? '');
        $sexe      = (int) ($line[6] ?? 0);
        $dateNais  = trim($line[7]  ?? '');
        $dateEmb   = trim($line[8]  ?? '');
        $dirLib    = trim($line[9]  ?? '');
        $grdLib    = trim($line[10] ?? '');
        $pflLib    = trim($line[11] ?? '');
        $password  = trim($line[12] ?? 'password123');

        if (empty($nom) || empty($prenom) || empty($email)) {
            $errors[] = "Ligne $rowNum : Nom, Prénom et Email sont obligatoires.";
            return false;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Ligne $rowNum : Email invalide ($email).";
            return false;
        }

        if ($db->table('employe')->where('Email_Emp', $email)->countAllResults() > 0) {
            $errors[] = "Ligne $rowNum : Email déjà utilisé ($email), ligne ignorée.";
            return false;
        }

        if ($matricule !== '' &&
            $db->table('employe')->where('Matricule_Emp', $matricule)->countAllResults() > 0) {
            $errors[] = "Ligne $rowNum : Matricule déjà utilisé ($matricule), ligne ignorée.";
            return false;
        }

        $dir   = $db->table('direction')->where('Nom_Dir', $dirLib)->get()->getRowArray();
        $idDir = $dir ? $dir['id_Dir'] : null;

        if (!$idDir && !empty($dirLib)) {
            $errors[] = "Ligne $rowNum : Direction introuvable ($dirLib), employé inséré sans direction.";
        }

        $grd   = $db->table('grade')->where('Libelle_Grd', $grdLib)->get()->getRowArray();
        $idGrd = $grd ? $grd['id_Grd'] : null;

        $pfl   = $db->table('profil')->where('Libelle_Pfl', $pflLib)->get()->getRowArray();
        $idPfl = $pfl ? $pfl['id_Pfl'] : 3;

        $db->table('employe')->insert([
            'Matricule_Emp'     => $matricule ?: null,
            'Nom_Emp'           => $nom,
            'Prenom_Emp'        => $prenom,
            'Email_Emp'         => $email,
            'Telephone_Emp'     => $tel,
            'Adresse_Emp'       => $adresse,
            'Sexe_Emp'          => in_array($sexe, [0, 1]) ? $sexe : 1,
            'DateNaissance_Emp' => $dateNais ?: null,
            'DateEmbauche_Emp'  => $dateEmb  ?: null,
            'Disponibilite_Emp' => 1,
            'id_Dir'            => $idDir,
            'id_Grd'            => $idGrd,
            'id_Pfl'            => $idPfl,
            'Password_Emp'      => password_hash(
                !empty($password) ? $password : 'password123',
                PASSWORD_DEFAULT
            ),
        ]);

        $idEmp = $db->insertID();

        if ($idEmp) {
            $db->table('solde_conge')->insert([
                'Annee_Sld'        => date('Y'),
                'NbJoursDroit_Sld' => 30,
                'NbJoursPris_Sld'  => 0,
                'id_Emp'           => $idEmp,
            ]);

            if ($idGrd) {
                $db->table('attribuer')->insert([
                    'Dte_Aff' => date('Y-m-d'),
                    'id_Emp'  => $idEmp,
                    'id_Grd'  => $idGrd,
                ]);
            }
        }

        return true;
    }
}