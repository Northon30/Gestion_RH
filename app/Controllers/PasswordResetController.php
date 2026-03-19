<?php

namespace App\Controllers;

/**
 * PasswordResetController
 *
 * La logique de réinitialisation de mot de passe est entièrement
 * gérée dans AuthController :
 *   - forgotPassword()   → affiche le formulaire de demande
 *   - sendResetLink()    → génère le token
 *   - resetPassword($t)  → affiche le formulaire de reset
 *   - updatePassword()   → enregistre le nouveau mot de passe
 */
class PasswordResetController extends BaseController
{
    public function index()
    {
        return redirect()->to('auth/forgot-password');
    }
}