<?php

namespace App\Controllers;

use App\Models\PieceJustificativeModel;
use App\Models\ActivityLogModel;

class PieceJustificativeController extends BaseController
{
    protected $model;
    protected $log;

    public function __construct()
    {
        $this->model = new PieceJustificativeModel();
        $this->log   = new ActivityLogModel();
    }

    public function index()
    {
        $data['pieces'] = $this->model->findAll();
        return view('piece_justificative/index', $data);
    }

    public function show($id)
    {
        $data['piece'] = $this->model->find($id);
        return view('piece_justificative/show', $data);
    }

    public function store()
    {
        $file = $this->request->getFile('fichier');
        $newName = $file->getRandomName();
        $file->move(WRITEPATH . 'uploads', $newName);

        $data = [
            'CheminFichier_PJ' => $newName,
            'DateDepot_PJ'     => date('Y-m-d'),
            'id_Abs'           => $this->request->getPost('id_Abs'),
        ];

        $this->model->insert($data);

        $this->log->insert([
            'Action_Log'      => 'CREATE',
            'Module_Log'      => 'PieceJustificative',
            'Description_Log' => 'Ajout d\'une pièce justificative pour l\'absence ID : ' . $data['id_Abs'],
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => session()->get('id_Emp'),
        ]);

        return redirect()->back()->with('success', 'Pièce justificative ajoutée avec succès');
    }

    public function delete($id)
    {
        $this->model->delete($id);

        $this->log->insert([
            'Action_Log'      => 'DELETE',
            'Module_Log'      => 'PieceJustificative',
            'Description_Log' => 'Suppression de la pièce justificative ID : ' . $id,
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => session()->get('id_Emp'),
        ]);

        return redirect()->back()->with('success', 'Pièce justificative supprimée avec succès');
    }
}