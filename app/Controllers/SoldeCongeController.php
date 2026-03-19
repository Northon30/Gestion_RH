<?php

namespace App\Controllers;

use App\Models\SoldeCongeModel;
use App\Models\EmployeModel;
use App\Models\ActivityLogModel;

class SoldeCongeController extends BaseController
{
    protected $model;
    protected $log;

    public function __construct()
    {
        $this->model = new SoldeCongeModel();
        $this->log   = new ActivityLogModel();
    }

    private function idEmp(): int { return (int) session()->get('id_Emp'); }

    private function checkAccess()
    {
        if ((int) session()->get('id_Pfl') !== 1) {
            return redirect()->to('dashboard')->with('error', 'Accès non autorisé.');
        }
        return null;
    }

    // ══════════════════════════════════════════════════════════
    // INDEX — liste tous les soldes (RH uniquement)
    // Accessible via : employe/show/{id} → section solde
    // ══════════════════════════════════════════════════════════
    public function index()
    {
        $redirect = $this->checkAccess();
        if ($redirect) return $redirect;

        $db = \Config\Database::connect();

        $soldes = $db->table('solde_conge')
            ->select('solde_conge.*, employe.Nom_Emp, employe.Prenom_Emp,
                      employe.Matricule_Emp, direction.Nom_Dir')
            ->join('employe',   'employe.id_Emp = solde_conge.id_Emp',   'left')
            ->join('direction', 'direction.id_Dir = employe.id_Dir',     'left')
            ->where('solde_conge.Annee_Sld', date('Y'))
            ->orderBy('employe.Nom_Emp', 'ASC')
            ->get()->getResultArray();

        return view('rh/solde_conge/index', [
            'title'  => 'Soldes de congés ' . date('Y'),
            'soldes' => $soldes,
        ]);
    }

    // ══════════════════════════════════════════════════════════
    // AJUSTER — modifier le solde d'un employé (RH uniquement)
    // Permet de corriger NbJoursDroit_Sld ou NbJoursPris_Sld
    // ══════════════════════════════════════════════════════════
    public function ajuster($id)
    {
        $redirect = $this->checkAccess();
        if ($redirect) return $redirect;

        $db    = \Config\Database::connect();
        $solde = $db->table('solde_conge')
            ->select('solde_conge.*, employe.Nom_Emp, employe.Prenom_Emp, employe.Matricule_Emp')
            ->join('employe', 'employe.id_Emp = solde_conge.id_Emp', 'left')
            ->where('solde_conge.id_Sld', $id)
            ->get()->getRowArray();

        if (!$solde) {
            return redirect()->to('employe')->with('error', 'Solde introuvable.');
        }

        $nbJoursDroit = (int) $this->request->getPost('NbJoursDroit_Sld');
        $nbJoursPris  = (int) $this->request->getPost('NbJoursPris_Sld');

        if ($nbJoursDroit < 0 || $nbJoursPris < 0) {
            return redirect()->back()->with('error', 'Les valeurs ne peuvent pas être négatives.');
        }

        if ($nbJoursPris > $nbJoursDroit) {
            return redirect()->back()
                             ->with('error', 'Le nombre de jours pris ne peut pas dépasser le droit total.');
        }

        $this->model->update($id, [
            'NbJoursDroit_Sld' => $nbJoursDroit,
            'NbJoursPris_Sld'  => $nbJoursPris,
        ]);

        $this->log->insert([
            'Action_Log'      => 'AJUSTER_SOLDE',
            'Module_Log'      => 'SoldeConge',
            'Description_Log' => 'Ajustement solde ID : ' . $id
                               . ' — Droit : ' . $nbJoursDroit
                               . ' / Pris : ' . $nbJoursPris,
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => $this->idEmp(),
        ]);

        return redirect()->to('employe/show/' . $solde['id_Emp'])
                         ->with('success', 'Solde de congés ajusté avec succès.');
    }

    // ══════════════════════════════════════════════════════════
    // INITIALISER NOUVELLE ANNÉE — créer les soldes pour tous
    // Route : POST solde-conge/initialiser
    // ══════════════════════════════════════════════════════════
    public function initialiserAnnee()
    {
        $redirect = $this->checkAccess();
        if ($redirect) return $redirect;

        $annee   = (int) $this->request->getPost('annee') ?: (int) date('Y');
        $nbJours = (int) $this->request->getPost('nb_jours') ?: 30;

        $db      = \Config\Database::connect();
        $employes = $db->table('employe')->get()->getResultArray();

        $crees  = 0;
        $ignores = 0;

        foreach ($employes as $emp) {
            // Vérifier si le solde pour cette année existe déjà
            $existe = $this->model
                ->where('id_Emp', $emp['id_Emp'])
                ->where('Annee_Sld', $annee)
                ->first();

            if ($existe) {
                $ignores++;
                continue;
            }

            $this->model->insert([
                'Annee_Sld'        => $annee,
                'NbJoursDroit_Sld' => $nbJours,
                'NbJoursPris_Sld'  => 0,
                'id_Emp'           => $emp['id_Emp'],
            ]);

            $crees++;
        }

        $this->log->insert([
            'Action_Log'      => 'INIT_ANNEE',
            'Module_Log'      => 'SoldeConge',
            'Description_Log' => 'Initialisation soldes ' . $annee
                               . ' — ' . $crees . ' créé(s), ' . $ignores . ' ignoré(s)',
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => $this->idEmp(),
        ]);

        return redirect()->to('solde-conge')
                         ->with('success', $crees . ' solde(s) créé(s) pour ' . $annee . '. ' . $ignores . ' ignoré(s).');
    }
}