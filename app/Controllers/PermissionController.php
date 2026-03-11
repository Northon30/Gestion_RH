<?php

namespace App\Controllers;

use App\Models\PermissionModel;
use App\Models\ProfilModel;
use App\Models\ActivityLogModel;

class PermissionController extends BaseController
{
    protected $model;
    protected $profilModel;
    protected $log;

    public function __construct()
    {
        $this->model       = new PermissionModel();
        $this->profilModel = new ProfilModel();
        $this->log         = new ActivityLogModel();
    }

    public function index()
    {
        $data['permissions'] = $this->model->findAll();
        return view('permission/index', $data);
    }

    public function show($id)
    {
        $data['permission'] = $this->model->find($id);
        return view('permission/show', $data);
    }

    public function create()
    {
        $data['profils'] = $this->profilModel->findAll();
        return view('permission/create', $data);
    }

    public function store()
    {
        $data = [
            'Module_Per' => $this->request->getPost('Module_Per'),
            'Action_Per' => $this->request->getPost('Action_Per'),
            'id_Pfl'     => $this->request->getPost('id_Pfl'),
        ];

        $this->model->insert($data);

        $this->log->insert([
            'Action_Log'      => 'CREATE',
            'Module_Log'      => 'Permission',
            'Description_Log' => 'Création permission : ' . $data['Module_Per'] . ' - ' . $data['Action_Per'],
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => session()->get('id_Emp'),
        ]);

        return redirect()->to('/permission')->with('success', 'Permission créée avec succès');
    }

    public function edit($id)
    {
        $data['permission'] = $this->model->find($id);
        $data['profils']    = $this->profilModel->findAll();
        return view('permission/edit', $data);
    }

    public function update($id)
    {
        $data = [
            'Module_Per' => $this->request->getPost('Module_Per'),
            'Action_Per' => $this->request->getPost('Action_Per'),
            'id_Pfl'     => $this->request->getPost('id_Pfl'),
        ];

        $this->model->update($id, $data);

        $this->log->insert([
            'Action_Log'      => 'UPDATE',
            'Module_Log'      => 'Permission',
            'Description_Log' => 'Modification permission ID : ' . $id,
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => session()->get('id_Emp'),
        ]);

        return redirect()->to('/permission')->with('success', 'Permission modifiée avec succès');
    }

    public function delete($id)
    {
        $this->model->delete($id);

        $this->log->insert([
            'Action_Log'      => 'DELETE',
            'Module_Log'      => 'Permission',
            'Description_Log' => 'Suppression permission ID : ' . $id,
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => session()->get('id_Emp'),
        ]);

        return redirect()->to('/permission')->with('success', 'Permission supprimée avec succès');
    }
}