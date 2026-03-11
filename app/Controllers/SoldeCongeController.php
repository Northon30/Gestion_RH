<?php

namespace App\Controllers;

use App\Models\SoldeCongeModel;
use App\Models\EmployeModel;
use App\Models\ActivityLogModel;

class SoldeCongeController extends BaseController
{
    protected $model;
    protected $employeModel;
    protected $log;

    public function __construct()
    {
        $this->model        = new SoldeCongeModel();
        $this->employeModel = new EmployeModel();
        $this->log          = new ActivityLogModel();
    }

    public function index()
    {
        $data['soldes'] = $this->model->findAll();
        return view('solde_conge/index', $data);
    }

    public function show($id)
    {
        $data['solde'] = $this->model->find($id);
        return view('solde_conge/show', $data);
    }

    public function create()
    {
        $data['employes'] = $this->employeModel->findAll();
        return view('solde_conge/create', $data);
    }

    public function store()
    {
        $data = [
            'Annee_Sld'        => $this->request->getPost('Annee_Sld'),
            'NbJoursDroit_Sld' => $this->request->getPost('NbJoursDroit_Sld'),
            'NbJoursPris_Sld'  => 0,
            'id_Emp'           => $this->request->getPost('id_Emp'),
        ];

        $this->model->insert($data);

        $this->log->insert([
            'Action_Log'      => 'CREATE',
            'Module_Log'      => 'SoldeConge',
            'Description_Log' => 'Création du solde congé pour l\'employé ID : ' . $data['id_Emp'],
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => session()->get('id_Emp'),
        ]);

        return redirect()->to('/solde-conge')->with('success', 'Solde congé créé avec succès');
    }

    public function edit($id)
    {
        $data['solde']    = $this->model->find($id);
        $data['employes'] = $this->employeModel->findAll();
        return view('solde_conge/edit', $data);
    }

    public function update($id)
    {
        $data = [
            'Annee_Sld'        => $this->request->getPost('Annee_Sld'),
            'NbJoursDroit_Sld' => $this->request->getPost('NbJoursDroit_Sld'),
            'NbJoursPris_Sld'  => $this->request->getPost('NbJoursPris_Sld'),
            'id_Emp'           => $this->request->getPost('id_Emp'),
        ];

        $this->model->update($id, $data);

        $this->log->insert([
            'Action_Log'      => 'UPDATE',
            'Module_Log'      => 'SoldeConge',
            'Description_Log' => 'Modification du solde congé ID : ' . $id,
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => session()->get('id_Emp'),
        ]);

        return redirect()->to('/solde-conge')->with('success', 'Solde congé modifié avec succès');
    }

    public function delete($id)
    {
        $this->model->delete($id);

        $this->log->insert([
            'Action_Log'      => 'DELETE',
            'Module_Log'      => 'SoldeConge',
            'Description_Log' => 'Suppression du solde congé ID : ' . $id,
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => session()->get('id_Emp'),
        ]);

        return redirect()->to('/solde-conge')->with('success', 'Solde congé supprimé avec succès');
    }
}