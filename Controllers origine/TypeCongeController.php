<?php

namespace App\Controllers;

use App\Models\ActivityLogModel;

class TypeCongeController extends BaseController
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

        $types = $db->table('type_conge')
            ->select('type_conge.id_Tcg, type_conge.Libelle_Tcg,
                      COUNT(conge.id_Cge) AS nb_conges')
            ->join('conge', 'conge.id_Tcg = type_conge.id_Tcg', 'left')
            ->groupBy('type_conge.id_Tcg')
            ->orderBy('type_conge.Libelle_Tcg')
            ->get()->getResultArray();

        $total       = count($types);
        $totalConges = array_sum(array_column($types, 'nb_conges'));
        $nonUtilises = count(array_filter($types, fn($t) => $t['nb_conges'] == 0));

        return view('rh/parametres/type-conge/index', [
            'title'       => 'Paramètres — Types de congés',
            'types'       => $types,
            'total'       => $total,
            'totalConges' => $totalConges,
            'nonUtilises' => $nonUtilises,
        ]);
    }

    // ══════════════════════════════════════════════════════════
    // SHOW
    // ══════════════════════════════════════════════════════════
    public function show($id)
    {
        if ($r = $this->checkRH()) return $r;

        $db   = \Config\Database::connect();
        $type = $db->table('type_conge')->where('id_Tcg', $id)->get()->getRowArray();

        if (!$type) {
            return redirect()->to('parametres/type-conge')->with('error', 'Type de congé introuvable.');
        }

        $conges = $db->table('conge')
            ->select('conge.id_Cge, conge.Libelle_Cge, conge.DateDebut_Cge,
                      conge.DateFin_Cge, conge.Statut_Cge,
                      employe.Nom_Emp, employe.Prenom_Emp')
            ->join('employe', 'employe.id_Emp = conge.id_Emp', 'left')
            ->where('conge.id_Tcg', $id)
            ->orderBy('conge.DateDebut_Cge', 'DESC')
            ->get()->getResultArray();

        return view('rh/parametres/type-conge/show', [
            'title'  => 'Type congé : ' . $type['Libelle_Tcg'],
            'type'   => $type,
            'conges' => $conges,
        ]);
    }

    // ══════════════════════════════════════════════════════════
    // CREATE
    // ══════════════════════════════════════════════════════════
    public function create()
    {
        if ($r = $this->checkRH()) return $r;

        return view('rh/parametres/type-conge/create', [
            'title' => 'Nouveau type de congé',
        ]);
    }

    // ══════════════════════════════════════════════════════════
    // STORE
    // ══════════════════════════════════════════════════════════
    public function store()
    {
        if ($r = $this->checkRH()) return $r;

        if (!$this->validate([
            'Libelle_Tcg' => 'required|min_length[2]|max_length[100]',
        ])) {
            return redirect()->back()->withInput()
                             ->with('errors', $this->validator->getErrors());
        }

        $db      = \Config\Database::connect();
        $libelle = trim($this->request->getPost('Libelle_Tcg'));

        $existe = $db->table('type_conge')
            ->where('LOWER(Libelle_Tcg)', strtolower($libelle))
            ->countAllResults();

        if ($existe > 0) {
            return redirect()->back()->withInput()
                             ->with('errors', ['Libelle_Tcg' => 'Ce type de congé existe déjà.']);
        }

        $db->table('type_conge')->insert(['Libelle_Tcg' => $libelle]);
        $newId = $db->insertID();

        $this->log->insert([
            'Action_Log'      => 'CREATE',
            'Module_Log'      => 'TypeConge',
            'Description_Log' => 'Création type congé : ' . $libelle,
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => $this->idEmp(),
        ]);

        return redirect()->to('parametres/type-conge/show/' . $newId)
                         ->with('success', 'Type de congé créé avec succès.');
    }

    // ══════════════════════════════════════════════════════════
    // EDIT
    // ══════════════════════════════════════════════════════════
    public function edit($id)
    {
        if ($r = $this->checkRH()) return $r;

        $db   = \Config\Database::connect();
        $type = $db->table('type_conge')->where('id_Tcg', $id)->get()->getRowArray();

        if (!$type) {
            return redirect()->to('parametres/type-conge')->with('error', 'Type de congé introuvable.');
        }

        return view('rh/parametres/type-conge/edit', [
            'title' => 'Modifier le type de congé',
            'type'  => $type,
        ]);
    }

    // ══════════════════════════════════════════════════════════
    // UPDATE
    // ══════════════════════════════════════════════════════════
    public function update($id)
    {
        if ($r = $this->checkRH()) return $r;

        $db   = \Config\Database::connect();
        $type = $db->table('type_conge')->where('id_Tcg', $id)->get()->getRowArray();

        if (!$type) {
            return redirect()->to('parametres/type-conge')->with('error', 'Type de congé introuvable.');
        }

        if (!$this->validate([
            'Libelle_Tcg' => 'required|min_length[2]|max_length[100]',
        ])) {
            return redirect()->back()->withInput()
                             ->with('errors', $this->validator->getErrors());
        }

        $libelle = trim($this->request->getPost('Libelle_Tcg'));

        $existe = $db->table('type_conge')
            ->where('LOWER(Libelle_Tcg)', strtolower($libelle))
            ->where('id_Tcg !=', $id)
            ->countAllResults();

        if ($existe > 0) {
            return redirect()->back()->withInput()
                             ->with('errors', ['Libelle_Tcg' => 'Ce libellé est déjà utilisé par un autre type de congé.']);
        }

        $db->table('type_conge')->where('id_Tcg', $id)->update(['Libelle_Tcg' => $libelle]);

        $this->log->insert([
            'Action_Log'      => 'UPDATE',
            'Module_Log'      => 'TypeConge',
            'Description_Log' => 'Modification type congé ID ' . $id . ' : ' . $type['Libelle_Tcg'] . ' -> ' . $libelle,
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => $this->idEmp(),
        ]);

        return redirect()->to('parametres/type-conge/show/' . $id)
                         ->with('success', 'Type de congé modifié avec succès.');
    }

    // ══════════════════════════════════════════════════════════
    // DELETE
    // ══════════════════════════════════════════════════════════
    public function delete($id)
    {
        if ($r = $this->checkRH()) return $r;

        $db   = \Config\Database::connect();
        $type = $db->table('type_conge')->where('id_Tcg', $id)->get()->getRowArray();

        if (!$type) {
            return redirect()->to('parametres/type-conge')->with('error', 'Type de congé introuvable.');
        }

        $nbConges = $db->table('conge')->where('id_Tcg', $id)->countAllResults();

        if ($nbConges > 0) {
            return redirect()->to('parametres/type-conge')
                             ->with('error', 'Impossible de supprimer ce type : '
                                           . $nbConges . ' congé(s) y sont associés.');
        }

        $db->table('type_conge')->where('id_Tcg', $id)->delete();

        $this->log->insert([
            'Action_Log'      => 'DELETE',
            'Module_Log'      => 'TypeConge',
            'Description_Log' => 'Suppression type congé : ' . $type['Libelle_Tcg'],
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => $this->idEmp(),
        ]);

        return redirect()->to('parametres/type-conge')
                         ->with('success', 'Type de congé supprimé avec succès.');
    }
}