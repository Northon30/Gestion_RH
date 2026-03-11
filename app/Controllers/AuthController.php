<?php

namespace App\Controllers;

use App\Models\EmployeModel;
use App\Models\ActivityLogModel;

class AuthController extends BaseController
{
    public function login()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/dashboard');
        }
        return view('auth/login');
    }

    public function authenticate()
    {
        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $model   = new EmployeModel();
        $employe = $model->where('Email_Emp', $email)->first();

        if ($employe && password_verify($password, $employe['Password_Emp'])) {

            // Récupérer le libellé du profil
            $db     = \Config\Database::connect();
            $profil = $db->table('profil')
                         ->where('id_Pfl', $employe['id_Pfl'])
                         ->get()->getRowArray();

            session()->set([
                'isLoggedIn' => true,
                'id_Emp'     => $employe['id_Emp'],
                'nom'        => $employe['Nom_Emp'],
                'prenom'     => $employe['Prenom_Emp'],
                'email'      => $employe['Email_Emp'],
                'id_Pfl'     => $employe['id_Pfl'],
                'id_Dir'     => $employe['id_Dir'],
                'profil'     => $profil['Libelle_Pfl'] ?? '',
            ]);

            $log = new ActivityLogModel();
            $log->insert([
                'Action_Log'      => 'LOGIN',
                'Module_Log'      => 'Auth',
                'Description_Log' => 'Connexion de ' . $employe['Nom_Emp'] . ' ' . $employe['Prenom_Emp'],
                'IpAdresse_Log'   => $this->request->getIPAddress(),
                'DateHeure_Log'   => date('Y-m-d H:i:s'),
                'id_Emp'          => $employe['id_Emp'],
            ]);

            return redirect()->to('/dashboard');
        }

        return redirect()->back()->with('error', 'Email ou mot de passe incorrect.');
    }

    public function logout()
    {
        $log = new ActivityLogModel();
        $log->insert([
            'Action_Log'      => 'LOGOUT',
            'Module_Log'      => 'Auth',
            'Description_Log' => 'Déconnexion de l\'employé ID : ' . session()->get('id_Emp'),
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => session()->get('id_Emp'),
        ]);

        session()->destroy();
        return redirect()->to('/login');
    }

    public function forgotPassword()
    {
        return view('auth/forgot_password');
    }

    public function resetPassword()
    {
        return view('auth/reset_password');
    }
}