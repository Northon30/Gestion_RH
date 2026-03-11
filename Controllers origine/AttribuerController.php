<?php

namespace App\Controllers;

use App\Models\AttribuerModel;
use App\Models\EmployeModel;
use App\Models\GradeModel;
use App\Models\ActivityLogModel;

class AttribuerController extends BaseController
{
    protected $model;
    protected $employeModel;
    protected $gradeModel;
    protected $log;

    public function __construct()
    {
        $this->model        = new AttribuerModel();
        $this->employeModel = new EmployeModel();
        $this->gradeModel   = new GradeModel();
        $this->log          = new ActivityLogModel();
    }

    public function index()
    {
        $data['attributions'] = $this->model->findAll();
        return view('attribuer/index', $data);
    }

    public function show($id)
    {
        $data['attribution'] = $this->model->find($id);
        return view('attribuer/show', $data);
    }

    public function create()
    {
        $data['employes'] = $this->employeModel->findAll();
        $data['grades']   = $this->gradeModel->findAll();
        return view('attribuer/create', $data);
    }

    public function store()
    {
        $data = [
            'Dte_Aff' => date('Y-m-d'),
            'id_Emp'  => $this->request->getPost('id_Emp'),
            'id_Grd'  => $this->request->getPost('id_Grd'),
        ];

        $this->model->insert($data);

        $this->log->insert([
            'Action_Log'      => 'CREATE',
            'Module_Log'      => 'Attribuer',
            'Description_Log' => 'Attribution grade à l\'employé ID : ' . $data['id_Emp'],
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => session()->get('id_Emp'),
        ]);

        return redirect()->to('/attribuer')->with('success', 'Grade attribué avec succès');
    }

    public function delete($id)
    {
        $this->model->delete($id);

        $this->log->insert([
            'Action_Log'      => 'DELETE',
            'Module_Log'      => 'Attribuer',
            'Description_Log' => 'Suppression attribution grade ID : ' . $id,
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => session()->get('id_Emp'),
        ]);

        return redirect()->to('/attribuer')->with('success', 'Attribution supprimée avec succès');
    }
}