<?php

namespace App\Controllers;

use App\Models\ActivityLogModel;

class ProfilUtilisateurController extends BaseController
{
    protected $log;

    public function __construct()
    {
        $this->log = new ActivityLogModel();
    }

    private function idEmp(): int { return (int) session()->get('id_Emp'); }

    private function view(string $vue, array $data = [])
    {
        $prefix = match((int) session()->get('id_Pfl')) {
            1 => 'RH',
            2 => 'chef',
            3 => 'employe',
            default => 'employe',
        };
        return view($prefix . '/profil/' . $vue, $data);
    }

    // ══════════════════════════════════════════════════════════
    // INDEX — fiche lecture seule
    // ══════════════════════════════════════════════════════════
    public function index()
    {
        $db  = \Config\Database::connect();
        $emp = $db->table('employe')
            ->select('employe.*, direction.Nom_Dir, grade.Libelle_Grd, profil.Libelle_Pfl')
            ->join('direction', 'direction.id_Dir = employe.id_Dir', 'left')
            ->join('grade',     'grade.id_Grd = employe.id_Grd',     'left')
            ->join('profil',    'profil.id_Pfl = employe.id_Pfl',    'left')
            ->where('employe.id_Emp', $this->idEmp())
            ->get()->getRowArray();

        if (!$emp) {
            return redirect()->to('dashboard')->with('error', 'Employé introuvable.');
        }

        return $this->view('index', [
            'title' => 'Mon profil',
            'emp'   => $emp,
        ]);
    }

    // ══════════════════════════════════════════════════════════
    // PASSWORD — formulaire
    // ══════════════════════════════════════════════════════════
    public function password()
    {
        // employe n'a pas de page password — redirection

        return $this->view('password', [
            'title' => 'Changer le mot de passe',
        ]);
    }

    // ══════════════════════════════════════════════════════════
    // UPDATE PASSWORD — traitement POST
    // ══════════════════════════════════════════════════════════
    public function updatePassword()
    {
        $db  = \Config\Database::connect();
        $emp = $db->table('employe')
            ->where('id_Emp', $this->idEmp())
            ->get()->getRowArray();

        if (!$emp) {
            return redirect()->to('dashboard')->with('error', 'Employé introuvable.');
        }

        $ancien       = $this->request->getPost('ancien_password');
        $nouveau      = $this->request->getPost('nouveau_password');
        $confirmation = $this->request->getPost('confirmation_password');

        $errors = [];

        if (!password_verify($ancien, $emp['Password_Emp'])) {
            $errors[] = 'L\'ancien mot de passe est incorrect.';
        }

        if (strlen($nouveau) < 8) {
            $errors[] = 'Le nouveau mot de passe doit contenir au moins 8 caractères.';
        }

        if ($nouveau !== $confirmation) {
            $errors[] = 'La confirmation ne correspond pas au nouveau mot de passe.';
        }

        if (!empty($ancien) && $ancien === $nouveau) {
            $errors[] = 'Le nouveau mot de passe doit être différent de l\'ancien.';
        }

        if (!empty($errors)) {
            return redirect()->back()->with('errors', $errors);
        }

        $db->table('employe')
            ->where('id_Emp', $this->idEmp())
            ->update(['Password_Emp' => password_hash($nouveau, PASSWORD_DEFAULT)]);

        $this->log->insert([
            'Action_Log'      => 'UPDATE',
            'Module_Log'      => 'Profil',
            'Description_Log' => 'Changement de mot de passe',
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => $this->idEmp(),
        ]);

        return redirect()->to('profil')
                         ->with('success', 'Mot de passe modifié avec succès.');
    }
}