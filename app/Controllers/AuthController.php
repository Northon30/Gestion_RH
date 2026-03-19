<?php

namespace App\Controllers;

use App\Models\EmployeModel;
use App\Models\ActivityLogModel;
use App\Models\PasswordResetModel;

class AuthController extends BaseController
{
    // ══════════════════════════════════════════════════════════
    // LOGIN
    // ══════════════════════════════════════════════════════════

    public function login()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to('dashboard');
        }
        return view('auth/login');
    }

    public function authenticate()
    {
        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        if (empty($email) || empty($password)) {
            return redirect()->back()->with('error', 'Email et mot de passe obligatoires.');
        }

        $model   = new EmployeModel();
        $employe = $model->where('Email_Emp', $email)->first();

        if (!$employe || !password_verify($password, $employe['Password_Emp'])) {
            return redirect()->back()->with('error', 'Email ou mot de passe incorrect.');
        }

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

        (new ActivityLogModel())->insert([
            'Action_Log'      => 'LOGIN',
            'Module_Log'      => 'Auth',
            'Description_Log' => 'Connexion de ' . $employe['Nom_Emp'] . ' ' . $employe['Prenom_Emp'],
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => $employe['id_Emp'],
        ]);

        return redirect()->to('dashboard');
    }

    // ══════════════════════════════════════════════════════════
    // LOGOUT
    // ══════════════════════════════════════════════════════════

    public function logout()
    {
        (new ActivityLogModel())->insert([
            'Action_Log'      => 'LOGOUT',
            'Module_Log'      => 'Auth',
            'Description_Log' => 'Déconnexion de l\'employé ID : ' . session()->get('id_Emp'),
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => session()->get('id_Emp'),
        ]);

        session()->destroy();
        return redirect()->to('login');
    }

    // ══════════════════════════════════════════════════════════
    // FORGOT PASSWORD — afficher le formulaire
    // ══════════════════════════════════════════════════════════

    public function forgotPassword()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to('dashboard');
        }
        return view('auth/forgot_password');
    }

    // ══════════════════════════════════════════════════════════
    // SEND RESET LINK — générer le token et "envoyer" le lien
    // ══════════════════════════════════════════════════════════

    public function sendResetLink()
    {
        $email = trim($this->request->getPost('email') ?? '');

        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return redirect()->back()->with('error', 'Veuillez saisir un email valide.');
        }

        $employe = (new EmployeModel())->where('Email_Emp', $email)->first();

        // On retourne toujours le même message pour ne pas révéler
        // si l'email existe ou non (sécurité)
        if (!$employe) {
            return redirect()->to('auth/forgot-password')
                             ->with('success', 'Si cet email existe, un lien de réinitialisation a été généré. Contactez votre administrateur.');
        }

        $resetModel = new PasswordResetModel();

        // Supprimer les anciens tokens de cet email
        $resetModel->where('email', $email)->delete();

        // Générer un nouveau token sécurisé
        $token = bin2hex(random_bytes(32));

        $resetModel->insert([
            'email'      => $email,
            'token'      => $token,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        // Lien de reset (à afficher ou envoyer par email)
        $lienReset = base_url('auth/reset-password/' . $token);

        // ⚠️ Pas de serveur email configuré → on affiche le lien directement
        // En production, remplacer par un envoi email (ex: CodeIgniter Email library)
        return redirect()->to('auth/forgot-password')
                         ->with('success', 'Lien de réinitialisation généré. Communiquez ce lien à l\'employé : ' . $lienReset);
    }

    // ══════════════════════════════════════════════════════════
    // RESET PASSWORD — afficher le formulaire avec token
    // ══════════════════════════════════════════════════════════

    public function resetPassword($token)
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to('dashboard');
        }

        $reset = (new PasswordResetModel())->where('token', $token)->first();

        if (!$reset) {
            return redirect()->to('login')
                             ->with('error', 'Lien invalide ou expiré. Veuillez refaire une demande.');
        }

        // Vérifier expiration (24h)
        $createdAt = strtotime($reset['created_at']);
        if ((time() - $createdAt) > 86400) {
            (new PasswordResetModel())->where('token', $token)->delete();
            return redirect()->to('login')
                             ->with('error', 'Ce lien a expiré (24h). Veuillez refaire une demande.');
        }

        return view('auth/reset_password', ['token' => $token]);
    }

    // ══════════════════════════════════════════════════════════
    // UPDATE PASSWORD — enregistrer le nouveau mot de passe
    // ══════════════════════════════════════════════════════════

    public function updatePassword()
    {
        $token           = $this->request->getPost('token');
        $password        = $this->request->getPost('password');
        $passwordConfirm = $this->request->getPost('password_confirm');

        if (empty($token) || empty($password)) {
            return redirect()->back()->with('error', 'Données manquantes.');
        }

        if (strlen($password) < 6) {
            return redirect()->back()->with('error', 'Le mot de passe doit contenir au moins 6 caractères.');
        }

        if ($password !== $passwordConfirm) {
            return redirect()->back()->with('error', 'Les mots de passe ne correspondent pas.');
        }

        $resetModel = new PasswordResetModel();
        $reset      = $resetModel->where('token', $token)->first();

        if (!$reset) {
            return redirect()->to('login')
                             ->with('error', 'Lien invalide ou expiré.');
        }

        // Vérifier expiration (24h)
        $createdAt = strtotime($reset['created_at']);
        if ((time() - $createdAt) > 86400) {
            $resetModel->where('token', $token)->delete();
            return redirect()->to('login')
                             ->with('error', 'Ce lien a expiré. Veuillez refaire une demande.');
        }

        $employeModel = new EmployeModel();
        $employe      = $employeModel->where('Email_Emp', $reset['email'])->first();

        if (!$employe) {
            return redirect()->to('login')->with('error', 'Employé introuvable.');
        }

        $employeModel->update($employe['id_Emp'], [
            'Password_Emp' => password_hash($password, PASSWORD_DEFAULT),
        ]);

        // Supprimer le token utilisé
        $resetModel->where('token', $token)->delete();

        (new ActivityLogModel())->insert([
            'Action_Log'      => 'RESET_PASSWORD',
            'Module_Log'      => 'Auth',
            'Description_Log' => 'Réinitialisation mot de passe — employé ID : ' . $employe['id_Emp'],
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => $employe['id_Emp'],
        ]);

        return redirect()->to('login')
                         ->with('success', 'Mot de passe réinitialisé avec succès. Vous pouvez vous connecter.');
    }
}