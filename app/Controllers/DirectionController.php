<?php

namespace App\Controllers;

use App\Models\DirectionModel;
use App\Models\ActivityLogModel;

class DirectionController extends BaseController
{
    protected $model;
    protected $log;

    public function __construct()
    {
        $this->model = new DirectionModel();
        $this->log   = new ActivityLogModel();
    }

    private function checkAccess()
    {
        if ((int) session()->get('id_Pfl') !== 1) {
            return redirect()->to('/dashboard')->with('error', 'Accès non autorisé.');
        }
        return null;
    }

    public function index()
    {
        $deny = $this->checkAccess();
        if ($deny) return $deny;

        $employeModel = new \App\Models\EmployeModel();
        $directions   = $this->model->findAll();

        foreach ($directions as &$dir) {
            $dir['effectif'] = $employeModel
                ->where('id_Dir', $dir['id_Dir'])
                ->countAllResults();
        }

        return view('rh/direction/index', [
            'title'      => 'Directions',
            'directions' => $directions,
        ]);
    }

    public function show($id)
    {
        $deny = $this->checkAccess();
        if ($deny) return $deny;

        $direction = $this->model->find($id);

        if (!$direction) {
            return redirect()->to('/direction')->with('error', 'Direction introuvable.');
        }

        $db       = \Config\Database::connect();
        $employes = $db->table('employe e')
            ->select('e.*, g.Libelle_Grd, p.Libelle_Pfl')
            ->join('grade g', 'g.id_Grd = e.id_Grd', 'left')
            ->join('profil p', 'p.id_Pfl = e.id_Pfl', 'left')
            ->where('e.id_Dir', $id)
            ->get()->getResultArray();

        return view('rh/direction/show', [
            'title'     => $direction['Nom_Dir'],
            'direction' => $direction,
            'employes'  => $employes,
        ]);
    }

    public function create()
    {
        $deny = $this->checkAccess();
        if ($deny) return $deny;

        return view('rh/direction/create', [
            'title' => 'Nouvelle Direction',
        ]);
    }

    public function store()
    {
        $deny = $this->checkAccess();
        if ($deny) return $deny;

        $nom = trim($this->request->getPost('Nom_Dir'));

        if (empty($nom)) {
            return redirect()->back()->with('error', 'Le nom de la direction est obligatoire.');
        }

        $this->model->insert(['Nom_Dir' => $nom]);

        $this->log->insert([
            'Action_Log'      => 'CREATE',
            'Module_Log'      => 'Direction',
            'Description_Log' => 'Création de la direction : ' . $nom,
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => session()->get('id_Emp'),
        ]);

        if ($this->request->getPost('action') === 'new') {
            return redirect()->to('/direction/create')
                             ->with('success', 'Direction créée. Vous pouvez en ajouter une autre.');
        }

        return redirect()->to('/direction')->with('success', 'Direction créée avec succès.');
    }

    public function edit($id)
    {
        $deny = $this->checkAccess();
        if ($deny) return $deny;

        $direction = $this->model->find($id);

        if (!$direction) {
            return redirect()->to('/direction')->with('error', 'Direction introuvable.');
        }

        return view('rh/direction/edit', [
            'title'     => 'Modifier la Direction',
            'direction' => $direction,
        ]);
    }

    public function update($id)
    {
        $deny = $this->checkAccess();
        if ($deny) return $deny;

        $nom = trim($this->request->getPost('Nom_Dir'));

        if (empty($nom)) {
            return redirect()->back()->with('error', 'Le nom de la direction est obligatoire.');
        }

        $this->model->update($id, ['Nom_Dir' => $nom]);

        $this->log->insert([
            'Action_Log'      => 'UPDATE',
            'Module_Log'      => 'Direction',
            'Description_Log' => 'Modification de la direction ID : ' . $id . ' → ' . $nom,
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => session()->get('id_Emp'),
        ]);

        return redirect()->to('/direction')->with('success', 'Direction modifiée avec succès.');
    }

    public function delete($id)
    {
        $deny = $this->checkAccess();
        if ($deny) return $deny;

        $direction = $this->model->find($id);

        if (!$direction) {
            return redirect()->to('/direction')->with('error', 'Direction introuvable.');
        }

        $employeModel = new \App\Models\EmployeModel();
        $effectif     = $employeModel->where('id_Dir', $id)->countAllResults();

        if ($effectif > 0) {
            return redirect()->to('/direction')
                             ->with('error', 'Impossible de supprimer une direction qui contient des employés.');
        }

        $this->model->delete($id);

        $this->log->insert([
            'Action_Log'      => 'DELETE',
            'Module_Log'      => 'Direction',
            'Description_Log' => 'Suppression de la direction : ' . $direction['Nom_Dir'],
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => session()->get('id_Emp'),
        ]);

        return redirect()->to('/direction')->with('success', 'Direction supprimée avec succès.');
    }
}