<?php

namespace App\Controllers;

use App\Models\ActivityLogModel;

class ProfilController extends BaseController
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

        $db      = \Config\Database::connect();
        $profils = $db->table('profil')
            ->select('profil.id_Pfl, profil.Libelle_Pfl,
                      COUNT(employe.id_Emp) AS nb_employes')
            ->join('employe', 'employe.id_Pfl = profil.id_Pfl', 'left')
            ->groupBy('profil.id_Pfl')
            ->orderBy('profil.Libelle_Pfl')
            ->get()->getResultArray();

        $total         = count($profils);
        $totalEmployes = array_sum(array_column($profils, 'nb_employes'));
        $nonUtilises   = count(array_filter($profils, fn($p) => $p['nb_employes'] == 0));

        return view('rh/parametres/profil/index', [
            'title'         => 'Paramètres — Profils',
            'profils'       => $profils,
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

        $db     = \Config\Database::connect();
        $profil = $db->table('profil')->where('id_Pfl', $id)->get()->getRowArray();

        if (!$profil) {
            return redirect()->to('parametres/profil')->with('error', 'Profil introuvable.');
        }

        $employes = $db->table('employe')
            ->select('employe.id_Emp, employe.Nom_Emp, employe.Prenom_Emp,
                      employe.Email_Emp, direction.Nom_Dir, grade.Libelle_Grd')
            ->join('direction', 'direction.id_Dir = employe.id_Dir', 'left')
            ->join('grade',     'grade.id_Grd = employe.id_Grd',     'left')
            ->where('employe.id_Pfl', $id)
            ->orderBy('employe.Nom_Emp')
            ->get()->getResultArray();

        return view('rh/parametres/profil/show', [
            'title'    => 'Profil : ' . $profil['Libelle_Pfl'],
            'profil'   => $profil,
            'employes' => $employes,
        ]);
    }

    // ══════════════════════════════════════════════════════════
    // CREATE
    // ══════════════════════════════════════════════════════════
    public function create()
    {
        if ($r = $this->checkRH()) return $r;

        return view('rh/parametres/profil/create', [
            'title' => 'Nouveau profil',
        ]);
    }

    // ══════════════════════════════════════════════════════════
    // STORE
    // ══════════════════════════════════════════════════════════
    public function store()
    {
        if ($r = $this->checkRH()) return $r;

        if (!$this->validate([
            'Libelle_Pfl' => 'required|min_length[2]|max_length[100]',
        ])) {
            return redirect()->back()->withInput()
                             ->with('errors', $this->validator->getErrors());
        }

        $db      = \Config\Database::connect();
        $libelle = trim($this->request->getPost('Libelle_Pfl'));

        $existe = $db->table('profil')
            ->where('LOWER(Libelle_Pfl)', strtolower($libelle))
            ->countAllResults();

        if ($existe > 0) {
            return redirect()->back()->withInput()
                             ->with('errors', ['Libelle_Pfl' => 'Ce profil existe déjà.']);
        }

        $db->table('profil')->insert(['Libelle_Pfl' => $libelle]);
        $newId = $db->insertID();

        $this->log->insert([
            'Action_Log'      => 'CREATE',
            'Module_Log'      => 'Profil',
            'Description_Log' => 'Création profil : ' . $libelle,
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => $this->idEmp(),
        ]);

        return redirect()->to('parametres/profil/show/' . $newId)
                         ->with('success', 'Profil créé avec succès.');
    }

    // ══════════════════════════════════════════════════════════
    // EDIT
    // ══════════════════════════════════════════════════════════
    public function edit($id)
    {
        if ($r = $this->checkRH()) return $r;

        $db     = \Config\Database::connect();
        $profil = $db->table('profil')->where('id_Pfl', $id)->get()->getRowArray();

        if (!$profil) {
            return redirect()->to('parametres/profil')->with('error', 'Profil introuvable.');
        }

        return view('rh/parametres/profil/edit', [
            'title'  => 'Modifier le profil',
            'profil' => $profil,
        ]);
    }

    // ══════════════════════════════════════════════════════════
    // UPDATE
    // ══════════════════════════════════════════════════════════
    public function update($id)
    {
        if ($r = $this->checkRH()) return $r;

        $db     = \Config\Database::connect();
        $profil = $db->table('profil')->where('id_Pfl', $id)->get()->getRowArray();

        if (!$profil) {
            return redirect()->to('parametres/profil')->with('error', 'Profil introuvable.');
        }

        if (!$this->validate([
            'Libelle_Pfl' => 'required|min_length[2]|max_length[100]',
        ])) {
            return redirect()->back()->withInput()
                             ->with('errors', $this->validator->getErrors());
        }

        $libelle = trim($this->request->getPost('Libelle_Pfl'));

        $existe = $db->table('profil')
            ->where('LOWER(Libelle_Pfl)', strtolower($libelle))
            ->where('id_Pfl !=', $id)
            ->countAllResults();

        if ($existe > 0) {
            return redirect()->back()->withInput()
                             ->with('errors', ['Libelle_Pfl' => 'Ce libellé est déjà utilisé par un autre profil.']);
        }

        $db->table('profil')->where('id_Pfl', $id)->update(['Libelle_Pfl' => $libelle]);

        $this->log->insert([
            'Action_Log'      => 'UPDATE',
            'Module_Log'      => 'Profil',
            'Description_Log' => 'Modification profil ID ' . $id . ' : ' . $profil['Libelle_Pfl'] . ' -> ' . $libelle,
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => $this->idEmp(),
        ]);

        return redirect()->to('parametres/profil/show/' . $id)
                         ->with('success', 'Profil modifié avec succès.');
    }

    // ══════════════════════════════════════════════════════════
    // DELETE
    // ══════════════════════════════════════════════════════════
    public function delete($id)
    {
        if ($r = $this->checkRH()) return $r;

        $db     = \Config\Database::connect();
        $profil = $db->table('profil')->where('id_Pfl', $id)->get()->getRowArray();

        if (!$profil) {
            return redirect()->to('parametres/profil')->with('error', 'Profil introuvable.');
        }

        $nbEmployes = $db->table('employe')->where('id_Pfl', $id)->countAllResults();

        if ($nbEmployes > 0) {
            return redirect()->to('parametres/profil')
                             ->with('error', 'Impossible de supprimer ce profil : '
                                           . $nbEmployes . ' employé(s) y sont associés.');
        }

        $db->table('profil')->where('id_Pfl', $id)->delete();

        $this->log->insert([
            'Action_Log'      => 'DELETE',
            'Module_Log'      => 'Profil',
            'Description_Log' => 'Suppression profil : ' . $profil['Libelle_Pfl'],
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => $this->idEmp(),
        ]);

        return redirect()->to('parametres/profil')
                         ->with('success', 'Profil supprimé avec succès.');
    }
}