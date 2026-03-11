<?php

namespace App\Controllers;

use App\Models\SInscrireModel;
use App\Models\EmployeModel;
use App\Models\FormationModel;
use App\Models\ActivityLogModel;

class SInscrireController extends BaseController
{
    protected $model;
    protected $employeModel;
    protected $formationModel;
    protected $log;

    public function __construct()
    {
        $this->model          = new SInscrireModel();
        $this->employeModel   = new EmployeModel();
        $this->formationModel = new FormationModel();
        $this->log            = new ActivityLogModel();
    }

    public function index()
    {
        $data['inscriptions'] = $this->model->findAll();
        return view('s_inscrire/index', $data);
    }

    public function show($id)
    {
        $data['inscription'] = $this->model->find($id);
        return view('s_inscrire/show', $data);
    }

    public function create()
    {
        $data['employes']   = $this->employeModel->findAll();
        $data['formations'] = $this->formationModel->findAll();
        return view('s_inscrire/create', $data);
    }

    public function store()
    {
        $data = [
            'Dte_Ins' => date('Y-m-d'),
            'Stt_Ins' => 'inscrit',
            'id_Emp'  => $this->request->getPost('id_Emp'),
            'id_Frm'  => $this->request->getPost('id_Frm'),
        ];

        $this->model->insert($data);

        $this->log->insert([
            'Action_Log'      => 'CREATE',
            'Module_Log'      => 'SInscrire',
            'Description_Log' => 'Inscription à la formation ID : ' . $data['id_Frm'],
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => session()->get('id_Emp'),
        ]);

        return redirect()->to('/s-inscrire')->with('success', 'Inscription effectuée avec succès');
    }

    public function valider($id)
    {
        $this->model->update($id, ['Stt_Ins' => 'valide']);

        $this->log->insert([
            'Action_Log'      => 'UPDATE',
            'Module_Log'      => 'SInscrire',
            'Description_Log' => 'Validation de l\'inscription ID : ' . $id,
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => session()->get('id_Emp'),
        ]);

        return redirect()->to('/s-inscrire')->with('success', 'Inscription validée avec succès');
    }

    public function delete($id)
    {
        $this->model->delete($id);

        $this->log->insert([
            'Action_Log'      => 'DELETE',
            'Module_Log'      => 'SInscrire',
            'Description_Log' => 'Suppression de l\'inscription ID : ' . $id,
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => session()->get('id_Emp'),
        ]);

        return redirect()->to('/s-inscrire')->with('success', 'Inscription supprimée avec succès');
    }
}