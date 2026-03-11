<?php

namespace App\Controllers;

use App\Models\ParticiperModel;
use App\Models\EmployeModel;
use App\Models\EvenementModel;
use App\Models\ActivityLogModel;

class ParticiperController extends BaseController
{
    protected $model;
    protected $employeModel;
    protected $evenementModel;
    protected $log;

    public function __construct()
    {
        $this->model          = new ParticiperModel();
        $this->employeModel   = new EmployeModel();
        $this->evenementModel = new EvenementModel();
        $this->log            = new ActivityLogModel();
    }

    public function index()
    {
        $data['participations'] = $this->model->findAll();
        return view('participer/index', $data);
    }

    public function show($id)
    {
        $data['participation'] = $this->model->find($id);
        return view('participer/show', $data);
    }

    public function create()
    {
        $data['employes']   = $this->employeModel->findAll();
        $data['evenements'] = $this->evenementModel->findAll();
        return view('participer/create', $data);
    }

    public function store()
    {
        $data = [
            'Dte_Sig' => date('Y-m-d'),
            'id_Emp'  => $this->request->getPost('id_Emp'),
            'id_Evt'  => $this->request->getPost('id_Evt'),
        ];

        $this->model->insert($data);

        $this->log->insert([
            'Action_Log'      => 'CREATE',
            'Module_Log'      => 'Participer',
            'Description_Log' => 'Participation à l\'événement ID : ' . $data['id_Evt'],
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => session()->get('id_Emp'),
        ]);

        return redirect()->to('/participer')->with('success', 'Participation enregistrée avec succès');
    }

    public function delete($id)
    {
        $this->model->delete($id);

        $this->log->insert([
            'Action_Log'      => 'DELETE',
            'Module_Log'      => 'Participer',
            'Description_Log' => 'Suppression participation ID : ' . $id,
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => session()->get('id_Emp'),
        ]);

        return redirect()->to('/participer')->with('success', 'Participation supprimée avec succès');
    }
}