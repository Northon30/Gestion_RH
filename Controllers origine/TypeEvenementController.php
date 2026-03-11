<?php

namespace App\Controllers;

use App\Models\ActivityLogModel;

class TypeEvenementController extends BaseController
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

        $types = $db->table('type_evenement')
            ->select('type_evenement.id_Tev, type_evenement.Libelle_Tev,
                      COUNT(evenement.id_Evt) AS nb_evenements')
            ->join('evenement', 'evenement.id_Tev = type_evenement.id_Tev', 'left')
            ->groupBy('type_evenement.id_Tev')
            ->orderBy('type_evenement.Libelle_Tev')
            ->get()->getResultArray();

        $total           = count($types);
        $totalEvenements = array_sum(array_column($types, 'nb_evenements'));
        $nonUtilises     = count(array_filter($types, fn($t) => $t['nb_evenements'] == 0));

        return view('rh/parametres/type-evenement/index', [
            'title'           => 'Paramètres — Types d\'événements',
            'types'           => $types,
            'total'           => $total,
            'totalEvenements' => $totalEvenements,
            'nonUtilises'     => $nonUtilises,
        ]);
    }

    public function show($id)
    {
        if ($r = $this->checkRH()) return $r;

        $db   = \Config\Database::connect();
        $type = $db->table('type_evenement')->where('id_Tev', $id)->get()->getRowArray();

        if (!$type) {
            return redirect()->to('parametres/type-evenement')->with('error', 'Type d\'événement introuvable.');
        }

        $evenements = $db->table('evenement')
            ->select('evenement.id_Evt, evenement.Description_Evt, evenement.Date_Evt,
                      COUNT(participer.Id_Ptr) AS nb_participants')
            ->join('participer', 'participer.id_Evt = evenement.id_Evt', 'left')
            ->where('evenement.id_Tev', $id)
            ->groupBy('evenement.id_Evt')
            ->orderBy('evenement.Date_Evt', 'DESC')
            ->get()->getResultArray();

        return view('rh/parametres/type-evenement/show', [
            'title'      => 'Type événement : ' . $type['Libelle_Tev'],
            'type'       => $type,
            'evenements' => $evenements,
        ]);
    }

    public function create()
    {
        if ($r = $this->checkRH()) return $r;

        return view('rh/parametres/type-evenement/create', [
            'title' => 'Nouveau type d\'événement',
        ]);
    }

    public function store()
    {
        if ($r = $this->checkRH()) return $r;

        if (!$this->validate([
            'Libelle_Tev' => 'required|min_length[2]|max_length[100]',
        ])) {
            return redirect()->back()->withInput()
                             ->with('errors', $this->validator->getErrors());
        }

        $db      = \Config\Database::connect();
        $libelle = trim($this->request->getPost('Libelle_Tev'));

        $existe = $db->table('type_evenement')
            ->where('LOWER(Libelle_Tev)', strtolower($libelle))
            ->countAllResults();

        if ($existe > 0) {
            return redirect()->back()->withInput()
                             ->with('errors', ['Libelle_Tev' => 'Ce type d\'événement existe déjà.']);
        }

        $db->table('type_evenement')->insert(['Libelle_Tev' => $libelle]);
        $newId = $db->insertID();

        $this->log->insert([
            'Action_Log'      => 'CREATE',
            'Module_Log'      => 'TypeEvenement',
            'Description_Log' => 'Création type événement : ' . $libelle,
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => $this->idEmp(),
        ]);

        return redirect()->to('parametres/type-evenement/show/' . $newId)
                         ->with('success', 'Type d\'événement créé avec succès.');
    }

    public function edit($id)
    {
        if ($r = $this->checkRH()) return $r;

        $db   = \Config\Database::connect();
        $type = $db->table('type_evenement')->where('id_Tev', $id)->get()->getRowArray();

        if (!$type) {
            return redirect()->to('parametres/type-evenement')->with('error', 'Type d\'événement introuvable.');
        }

        return view('rh/parametres/type-evenement/edit', [
            'title' => 'Modifier le type d\'événement',
            'type'  => $type,
        ]);
    }

    public function update($id)
    {
        if ($r = $this->checkRH()) return $r;

        $db   = \Config\Database::connect();
        $type = $db->table('type_evenement')->where('id_Tev', $id)->get()->getRowArray();

        if (!$type) {
            return redirect()->to('parametres/type-evenement')->with('error', 'Type d\'événement introuvable.');
        }

        if (!$this->validate([
            'Libelle_Tev' => 'required|min_length[2]|max_length[100]',
        ])) {
            return redirect()->back()->withInput()
                             ->with('errors', $this->validator->getErrors());
        }

        $libelle = trim($this->request->getPost('Libelle_Tev'));

        $existe = $db->table('type_evenement')
            ->where('LOWER(Libelle_Tev)', strtolower($libelle))
            ->where('id_Tev !=', $id)
            ->countAllResults();

        if ($existe > 0) {
            return redirect()->back()->withInput()
                             ->with('errors', ['Libelle_Tev' => 'Ce libellé est déjà utilisé par un autre type d\'événement.']);
        }

        $db->table('type_evenement')->where('id_Tev', $id)->update(['Libelle_Tev' => $libelle]);

        $this->log->insert([
            'Action_Log'      => 'UPDATE',
            'Module_Log'      => 'TypeEvenement',
            'Description_Log' => 'Modification type événement ID ' . $id . ' : ' . $type['Libelle_Tev'] . ' -> ' . $libelle,
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => $this->idEmp(),
        ]);

        return redirect()->to('parametres/type-evenement/show/' . $id)
                         ->with('success', 'Type d\'événement modifié avec succès.');
    }

    public function delete($id)
    {
        if ($r = $this->checkRH()) return $r;

        $db   = \Config\Database::connect();
        $type = $db->table('type_evenement')->where('id_Tev', $id)->get()->getRowArray();

        if (!$type) {
            return redirect()->to('parametres/type-evenement')->with('error', 'Type d\'événement introuvable.');
        }

        $nbEvenements = $db->table('evenement')->where('id_Tev', $id)->countAllResults();

        if ($nbEvenements > 0) {
            return redirect()->to('parametres/type-evenement')
                             ->with('error', 'Impossible de supprimer ce type : '
                                           . $nbEvenements . ' événement(s) y sont associés.');
        }

        $db->table('type_evenement')->where('id_Tev', $id)->delete();

        $this->log->insert([
            'Action_Log'      => 'DELETE',
            'Module_Log'      => 'TypeEvenement',
            'Description_Log' => 'Suppression type événement : ' . $type['Libelle_Tev'],
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => $this->idEmp(),
        ]);

        return redirect()->to('parametres/type-evenement')
                         ->with('success', 'Type d\'événement supprimé avec succès.');
    }
}