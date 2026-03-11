<?php

namespace App\Controllers;

use App\Models\ObtenirModel;
use App\Models\EmployeModel;
use App\Models\CompetenceModel;
use App\Models\ActivityLogModel;

class ObtenirController extends BaseController
{
    protected $model;
    protected $employeModel;
    protected $competenceModel;
    protected $log;

    public function __construct()
    {
        $this->model           = new ObtenirModel();
        $this->employeModel    = new EmployeModel();
        $this->competenceModel = new CompetenceModel();
        $this->log             = new ActivityLogModel();
    }

    public function index()
    {
        $data['obtenir'] = $this->model->findAll();
        return view('obtenir/index', $data);
    }

    public function show($id)
    {
        $data['obtenir'] = $this->model->find($id);
        return view('obtenir/show', $data);
    }

    public function create()
    {
        $data['employes']    = $this->employeModel->findAll();
        $data['competences'] = $this->competenceModel->findAll();
        return view('obtenir/create', $data);
    }

    public function store()
    {
        $data = [
            'Dte_Obt'   => date('Y-m-d'),
            'Niveau_Obt' => $this->request->getPost('Niveau_Obt'),
            'id_Emp'    => $this->request->getPost('id_Emp'),
            'id_Cmp'    => $this->request->getPost('id_Cmp'),
        ];

        $this->model->insert($data);

        $this->log->insert([
            'Action_Log'      => 'CREATE',
            'Module_Log'      => 'Obtenir',
            'Description_Log' => 'Attribution compétence à l\'employé ID : ' . $data['id_Emp'],
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => session()->get('id_Emp'),
        ]);

        return redirect()->to('/obtenir')->with('success', 'Compétence attribuée avec succès');
    }

    public function edit($id)
    {
        $data['obtenir']     = $this->model->find($id);
        $data['employes']    = $this->employeModel->findAll();
        $data['competences'] = $this->competenceModel->findAll();
        return view('obtenir/edit', $data);
    }

    public function update($id)
    {
        $data = [
            'Niveau_Obt' => $this->request->getPost('Niveau_Obt'),
            'id_Emp'    => $this->request->getPost('id_Emp'),
            'id_Cmp'    => $this->request->getPost('id_Cmp'),
        ];

        $this->model->update($id, $data);

        $this->log->insert([
            'Action_Log'      => 'UPDATE',
            'Module_Log'      => 'Obtenir',
            'Description_Log' => 'Modification compétence ID : ' . $id,
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => session()->get('id_Emp'),
        ]);

        return redirect()->to('/obtenir')->with('success', 'Compétence modifiée avec succès');
    }

    public function delete($id)
    {
        $this->model->delete($id);

        $this->log->insert([
            'Action_Log'      => 'DELETE',
            'Module_Log'      => 'Obtenir',
            'Description_Log' => 'Suppression compétence ID : ' . $id,
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => session()->get('id_Emp'),
        ]);

        return redirect()->to('/obtenir')->with('success', 'Compétence supprimée avec succès');
    }
}