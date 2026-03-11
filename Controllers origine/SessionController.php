<?php

namespace App\Controllers;

use App\Models\SessionModel;

class SessionController extends BaseController
{
    public function index()
    {
        $data['sessions'] = (new SessionModel())->findAll();
        return view('session/index', $data);
    }

    public function delete($id)
    {
        (new SessionModel())->delete($id);
        return redirect()->to('/session')->with('success', 'Session supprimée avec succès');
    }
}