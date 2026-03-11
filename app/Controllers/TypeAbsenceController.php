<?php

namespace App\Controllers;

use App\Models\ActivityLogModel;

class TypeAbsenceController extends BaseController
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

    public function index()
    {
        if ($r = $this->checkRH()) return $r;

        $db = \Config\Database::connect();

        $types = $db->table('type_absence')
            ->select('type_absence.id_TAbs, type_absence.Libelle_TAbs,
                      COUNT(absence.id_Abs) AS nb_absences')
            ->join('absence', 'absence.id_TAbs = type_absence.id_TAbs', 'left')
            ->groupBy('type_absence.id_TAbs')
            ->orderBy('type_absence.Libelle_TAbs')
            ->get()->getResultArray();

        $total         = count($types);
        $totalAbsences = array_sum(array_column($types, 'nb_absences'));
        $nonUtilises   = count(array_filter($types, fn($t) => $t['nb_absences'] == 0));

        return view('rh/parametres/type-absence/index', [
            'title'         => 'Paramètres — Types d\'absences',
            'types'         => $types,
            'total'         => $total,
            'totalAbsences' => $totalAbsences,
            'nonUtilises'   => $nonUtilises,
        ]);
    }

    public function show($id)
    {
        if ($r = $this->checkRH()) return $r;

        $db   = \Config\Database::connect();
        $type = $db->table('type_absence')->where('id_TAbs', $id)->get()->getRowArray();

        if (!$type) {
            return redirect()->to('parametres/type-absence')->with('error', 'Type d\'absence introuvable.');
        }

        $absences = $db->table('absence')
            ->select('absence.id_Abs, absence.DateDebut_Abs, absence.DateFin_Abs,
                      absence.Motif_Abs, absence.Statut_Abs,
                      employe.Nom_Emp, employe.Prenom_Emp')
            ->join('employe', 'employe.id_Emp = absence.id_Emp', 'left')
            ->where('absence.id_TAbs', $id)
            ->orderBy('absence.DateDebut_Abs', 'DESC')
            ->get()->getResultArray();

        return view('rh/parametres/type-absence/show', [
            'title'    => 'Type absence : ' . $type['Libelle_TAbs'],
            'type'     => $type,
            'absences' => $absences,
        ]);
    }

    public function create()
    {
        if ($r = $this->checkRH()) return $r;

        return view('rh/parametres/type-absence/create', [
            'title' => 'Nouveau type d\'absence',
        ]);
    }

    public function store()
    {
        if ($r = $this->checkRH()) return $r;

        if (!$this->validate([
            'Libelle_TAbs' => 'required|min_length[2]|max_length[100]',
        ])) {
            return redirect()->back()->withInput()
                             ->with('errors', $this->validator->getErrors());
        }

        $db      = \Config\Database::connect();
        $libelle = trim($this->request->getPost('Libelle_TAbs'));

        $existe = $db->table('type_absence')
            ->where('LOWER(Libelle_TAbs)', strtolower($libelle))
            ->countAllResults();

        if ($existe > 0) {
            return redirect()->back()->withInput()
                             ->with('errors', ['Libelle_TAbs' => 'Ce type d\'absence existe déjà.']);
        }

        $db->table('type_absence')->insert(['Libelle_TAbs' => $libelle]);
        $newId = $db->insertID();

        $this->log->insert([
            'Action_Log'      => 'CREATE',
            'Module_Log'      => 'TypeAbsence',
            'Description_Log' => 'Création type absence : ' . $libelle,
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => $this->idEmp(),
        ]);

        return redirect()->to('parametres/type-absence/show/' . $newId)
                         ->with('success', 'Type d\'absence créé avec succès.');
    }

    public function edit($id)
    {
        if ($r = $this->checkRH()) return $r;

        $db   = \Config\Database::connect();
        $type = $db->table('type_absence')->where('id_TAbs', $id)->get()->getRowArray();

        if (!$type) {
            return redirect()->to('parametres/type-absence')->with('error', 'Type d\'absence introuvable.');
        }

        return view('rh/parametres/type-absence/edit', [
            'title' => 'Modifier le type d\'absence',
            'type'  => $type,
        ]);
    }

    public function update($id)
    {
        if ($r = $this->checkRH()) return $r;

        $db   = \Config\Database::connect();
        $type = $db->table('type_absence')->where('id_TAbs', $id)->get()->getRowArray();

        if (!$type) {
            return redirect()->to('parametres/type-absence')->with('error', 'Type d\'absence introuvable.');
        }

        if (!$this->validate([
            'Libelle_TAbs' => 'required|min_length[2]|max_length[100]',
        ])) {
            return redirect()->back()->withInput()
                             ->with('errors', $this->validator->getErrors());
        }

        $libelle = trim($this->request->getPost('Libelle_TAbs'));

        $existe = $db->table('type_absence')
            ->where('LOWER(Libelle_TAbs)', strtolower($libelle))
            ->where('id_TAbs !=', $id)
            ->countAllResults();

        if ($existe > 0) {
            return redirect()->back()->withInput()
                             ->with('errors', ['Libelle_TAbs' => 'Ce libellé est déjà utilisé par un autre type d\'absence.']);
        }

        $db->table('type_absence')->where('id_TAbs', $id)->update(['Libelle_TAbs' => $libelle]);

        $this->log->insert([
            'Action_Log'      => 'UPDATE',
            'Module_Log'      => 'TypeAbsence',
            'Description_Log' => 'Modification type absence ID ' . $id . ' : ' . $type['Libelle_TAbs'] . ' -> ' . $libelle,
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => $this->idEmp(),
        ]);

        return redirect()->to('parametres/type-absence/show/' . $id)
                         ->with('success', 'Type d\'absence modifié avec succès.');
    }

    public function delete($id)
    {
        if ($r = $this->checkRH()) return $r;

        $db   = \Config\Database::connect();
        $type = $db->table('type_absence')->where('id_TAbs', $id)->get()->getRowArray();

        if (!$type) {
            return redirect()->to('parametres/type-absence')->with('error', 'Type d\'absence introuvable.');
        }

        $nbAbsences = $db->table('absence')->where('id_TAbs', $id)->countAllResults();

        if ($nbAbsences > 0) {
            return redirect()->to('parametres/type-absence')
                             ->with('error', 'Impossible de supprimer ce type : '
                                           . $nbAbsences . ' absence(s) y sont associées.');
        }

        $db->table('type_absence')->where('id_TAbs', $id)->delete();

        $this->log->insert([
            'Action_Log'      => 'DELETE',
            'Module_Log'      => 'TypeAbsence',
            'Description_Log' => 'Suppression type absence : ' . $type['Libelle_TAbs'],
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => $this->idEmp(),
        ]);

        return redirect()->to('parametres/type-absence')
                         ->with('success', 'Type d\'absence supprimé avec succès.');
    }
}