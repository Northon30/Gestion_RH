<?php

namespace App\Controllers;

use App\Models\ActivityLogModel;

class GradeController extends BaseController
{
    protected $log;

    public function __construct()
    {
        $this->log = new ActivityLogModel();
    }

    private function idEmp(): int { return (int) session()->get('id_Emp'); }

    private function checkRH()
    {
        if ((int) session()->get('id_Pfl') !== 1) {
            return redirect()->to('dashboard')->with('error', 'Accès réservé aux RH.');
        }
        return null;
    }

    // ══════════════════════════════════════════════════════════
    // INDEX
    // ══════════════════════════════════════════════════════════
    public function index()
    {
        if ($r = $this->checkRH()) return $r;

        $db = \Config\Database::connect();

        $grades = $db->table('grade')
            ->select('grade.id_Grd, grade.Libelle_Grd,
                      COUNT(employe.id_Emp) AS nb_employes')
            ->join('employe', 'employe.id_Grd = grade.id_Grd', 'left')
            ->groupBy('grade.id_Grd')
            ->orderBy('grade.Libelle_Grd')
            ->get()->getResultArray();

        $total        = count($grades);
        $totalEmployes = array_sum(array_column($grades, 'nb_employes'));
        $nonUtilises  = count(array_filter($grades, fn($g) => $g['nb_employes'] == 0));

        return view('rh/parametres/grade/index', [
            'title'         => 'Paramètres — Grades',
            'grades'        => $grades,
            'total'         => $total,
            'totalEmployes' => $totalEmployes,
            'nonUtilises'   => $nonUtilises,
        ]);
    }

    // ══════════════════════════════════════════════════════════
    // SHOW
    // ══════════════════════════════════════════════════════════
    public function show($id)
    {
        if ($r = $this->checkRH()) return $r;

        $db    = \Config\Database::connect();
        $grade = $db->table('grade')->where('id_Grd', $id)->get()->getRowArray();

        if (!$grade) {
            return redirect()->to('parametres/grade')->with('error', 'Grade introuvable.');
        }

        // Employés ayant ce grade
        $employes = $db->table('employe')
            ->select('employe.id_Emp, employe.Nom_Emp, employe.Prenom_Emp,
                      employe.Email_Emp, direction.Nom_Dir')
            ->join('direction', 'direction.id_Dir = employe.id_Dir', 'left')
            ->where('employe.id_Grd', $id)
            ->orderBy('employe.Nom_Emp')
            ->get()->getResultArray();

        return view('rh/parametres/grade/show', [
            'title'    => 'Grade : ' . $grade['Libelle_Grd'],
            'grade'    => $grade,
            'employes' => $employes,
        ]);
    }

    // ══════════════════════════════════════════════════════════
    // CREATE
    // ══════════════════════════════════════════════════════════
    public function create()
    {
        if ($r = $this->checkRH()) return $r;

        return view('rh/parametres/grade/create', [
            'title' => 'Nouveau grade',
        ]);
    }

    // ══════════════════════════════════════════════════════════
    // STORE
    // ══════════════════════════════════════════════════════════
    public function store()
    {
        if ($r = $this->checkRH()) return $r;

        if (!$this->validate([
            'Libelle_Grd' => 'required|min_length[2]|max_length[100]',
        ])) {
            return redirect()->back()->withInput()
                             ->with('errors', $this->validator->getErrors());
        }

        $db      = \Config\Database::connect();
        $libelle = trim($this->request->getPost('Libelle_Grd'));

        // Vérifier doublon
        $existe = $db->table('grade')
            ->where('LOWER(Libelle_Grd)', strtolower($libelle))
            ->countAllResults();

        if ($existe > 0) {
            return redirect()->back()->withInput()
                             ->with('errors', ['Libelle_Grd' => 'Ce grade existe déjà.']);
        }

        $db->table('grade')->insert(['Libelle_Grd' => $libelle]);
        $newId = $db->insertID();

        $this->log->insert([
            'Action_Log'      => 'CREATE',
            'Module_Log'      => 'Grade',
            'Description_Log' => 'Création grade : ' . $libelle,
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => $this->idEmp(),
        ]);

        return redirect()->to('parametres/grade/show/' . $newId)
                         ->with('success', 'Grade créé avec succès.');
    }

    // ══════════════════════════════════════════════════════════
    // EDIT
    // ══════════════════════════════════════════════════════════
    public function edit($id)
    {
        if ($r = $this->checkRH()) return $r;

        $db    = \Config\Database::connect();
        $grade = $db->table('grade')->where('id_Grd', $id)->get()->getRowArray();

        if (!$grade) {
            return redirect()->to('parametres/grade')->with('error', 'Grade introuvable.');
        }

        return view('rh/parametres/grade/edit', [
            'title' => 'Modifier le grade',
            'grade' => $grade,
        ]);
    }

    // ══════════════════════════════════════════════════════════
    // UPDATE
    // ══════════════════════════════════════════════════════════
    public function update($id)
    {
        if ($r = $this->checkRH()) return $r;

        $db    = \Config\Database::connect();
        $grade = $db->table('grade')->where('id_Grd', $id)->get()->getRowArray();

        if (!$grade) {
            return redirect()->to('parametres/grade')->with('error', 'Grade introuvable.');
        }

        if (!$this->validate([
            'Libelle_Grd' => 'required|min_length[2]|max_length[100]',
        ])) {
            return redirect()->back()->withInput()
                             ->with('errors', $this->validator->getErrors());
        }

        $libelle = trim($this->request->getPost('Libelle_Grd'));

        // Vérifier doublon (exclure l'actuel)
        $existe = $db->table('grade')
            ->where('LOWER(Libelle_Grd)', strtolower($libelle))
            ->where('id_Grd !=', $id)
            ->countAllResults();

        if ($existe > 0) {
            return redirect()->back()->withInput()
                             ->with('errors', ['Libelle_Grd' => 'Ce libellé est déjà utilisé par un autre grade.']);
        }

        $db->table('grade')->where('id_Grd', $id)->update(['Libelle_Grd' => $libelle]);

        $this->log->insert([
            'Action_Log'      => 'UPDATE',
            'Module_Log'      => 'Grade',
            'Description_Log' => 'Modification grade ID ' . $id . ' : ' . $grade['Libelle_Grd'] . ' -> ' . $libelle,
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => $this->idEmp(),
        ]);

        return redirect()->to('parametres/grade/show/' . $id)
                         ->with('success', 'Grade modifié avec succès.');
    }

    // ══════════════════════════════════════════════════════════
    // DELETE
    // ══════════════════════════════════════════════════════════
    public function delete($id)
    {
        if ($r = $this->checkRH()) return $r;

        $db    = \Config\Database::connect();
        $grade = $db->table('grade')->where('id_Grd', $id)->get()->getRowArray();

        if (!$grade) {
            return redirect()->to('parametres/grade')->with('error', 'Grade introuvable.');
        }

        // Bloquer si des employés utilisent ce grade
        $nbEmployes = $db->table('employe')->where('id_Grd', $id)->countAllResults();

        if ($nbEmployes > 0) {
            return redirect()->to('parametres/grade')
                             ->with('error', 'Impossible de supprimer ce grade : '
                                           . $nbEmployes . ' employé(s) y sont associés.');
        }

        $db->table('grade')->where('id_Grd', $id)->delete();

        $this->log->insert([
            'Action_Log'      => 'DELETE',
            'Module_Log'      => 'Grade',
            'Description_Log' => 'Suppression grade : ' . $grade['Libelle_Grd'],
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => $this->idEmp(),
        ]);

        return redirect()->to('parametres/grade')
                         ->with('success', 'Grade supprimé avec succès.');
    }
}