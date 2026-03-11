<?php

namespace App\Controllers;

use App\Models\EmployeModel;
use App\Models\PasswordResetModel;

class PasswordResetController extends BaseController
{
    public function index()
    {
        $data['resets'] = (new PasswordResetModel())->findAll();
        return view('password_reset/index', $data);
    }

    public function store()
    {
        $email   = $this->request->getPost('email');
        $employe = (new EmployeModel())->where('Email_Emp', $email)->first();

        if (!$employe) {
            return redirect()->back()->with('error', 'Email introuvable');
        }

        $token = bin2hex(random_bytes(32));

        (new PasswordResetModel())->insert([
            'email'      => $email,
            'token'      => $token,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/login')->with('success', 'Lien de réinitialisation envoyé');
    }

    public function reset($token)
    {
        $reset = (new PasswordResetModel())->where('token', $token)->first();

        if (!$reset) {
            return redirect()->to('/login')->with('error', 'Token invalide');
        }

        return view('password_reset/reset', ['token' => $token]);
    }

    public function update()
    {
        $token    = $this->request->getPost('token');
        $password = $this->request->getPost('password');

        $reset   = (new PasswordResetModel())->where('token', $token)->first();
        $employe = (new EmployeModel())->where('Email_Emp', $reset['email'])->first();

        (new EmployeModel())->update($employe['id_Emp'], [
            'Password_Emp' => password_hash($password, PASSWORD_DEFAULT),
        ]);

        (new PasswordResetModel())->where('token', $token)->delete();

        return redirect()->to('/login')->with('success', 'Mot de passe réinitialisé avec succès');
    }
}