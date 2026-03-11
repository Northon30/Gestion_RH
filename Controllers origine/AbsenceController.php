<?php

namespace App\Controllers;

use App\Models\AbsenceModel;
use App\Models\EmployeModel;
use App\Models\TypeAbsenceModel;
use App\Models\PieceJustificativeModel;
use App\Models\NotificationModel;
use App\Models\ActivityLogModel;

class AbsenceController extends BaseController
{
    protected $model;
    protected $notif;
    protected $log;

    public function __construct()
    {
        $this->model = new AbsenceModel();
        $this->notif = new NotificationModel();
        $this->log   = new ActivityLogModel();
    }

    private function idEmp(): int { return (int) session()->get('id_Emp'); }
    private function idPfl(): int { return (int) session()->get('id_Pfl'); }

    private function getRHIds(): array
    {
        $db = \Config\Database::connect();
        return array_column(
            $db->table('employe')->where('id_Pfl', 1)->get()->getResultArray(),
            'id_Emp'
        );
    }

    private function getChefIds(): array
    {
        $db = \Config\Database::connect();
        return array_column(
            $db->table('employe')->where('id_Pfl', 2)->get()->getResultArray(),
            'id_Emp'
        );
    }

    // ── INDEX ─────────────────────────────────────────────────
    public function index()
    {
        $db    = \Config\Database::connect();
        $idPfl = $this->idPfl();
        $idEmp = $this->idEmp();

        $query = $db->table('absence')
            ->select('absence.*, employe.Nom_Emp, employe.Prenom_Emp,
                      employe.id_Dir, direction.Nom_Dir,
                      type_absence.Libelle_TAbs')
            ->join('employe',      'employe.id_Emp = absence.id_Emp',        'left')
            ->join('direction',    'direction.id_Dir = employe.id_Dir',      'left')
            ->join('type_absence', 'type_absence.id_TAbs = absence.id_TAbs', 'left');

        if ($idPfl == 3) {
            $query->where('absence.id_Emp', $idEmp);
        }

        if ($idPfl == 2) {
            $emp = (new EmployeModel())->find($idEmp);
            $query->groupStart()
                    ->where('absence.id_Emp', $idEmp)
                    ->orGroupStart()
                        ->where('employe.id_Dir', $emp['id_Dir'])
                        ->where('absence.id_Emp !=', $idEmp)
                        ->whereIn('absence.Statut_Abs', ['valide_rh', 'approuve', 'rejete'])
                    ->groupEnd()
                  ->groupEnd();
        }

        $absences = $query->orderBy('absence.DateDebut_Abs', 'DESC')
                          ->get()->getResultArray();

        $data['title']        = 'Absences';
        $data['absences']     = $absences;
        $data['idPfl']        = $idPfl;
        $data['idEmp']        = $idEmp;
        $data['directions']   = $db->table('direction')
                                   ->orderBy('Nom_Dir', 'ASC')
                                   ->get()->getResultArray();
        $data['typesAbsence'] = $db->table('type_absence')
                                   ->orderBy('Libelle_TAbs', 'ASC')
                                   ->get()->getResultArray();

        return view('rh/absence/index', $data);
    }

    // ── SHOW ──────────────────────────────────────────────────
    public function show($id)
    {
        $db    = \Config\Database::connect();
        $idPfl = $this->idPfl();
        $idEmp = $this->idEmp();

        $absence = $db->table('absence')
            ->select('absence.*, employe.Nom_Emp, employe.Prenom_Emp,
                      employe.Email_Emp, employe.id_Dir,
                      direction.Nom_Dir, type_absence.Libelle_TAbs,
                      validRH.Nom_Emp    AS NomValidRH,
                      validRH.Prenom_Emp AS PrenomValidRH,
                      validDir.Nom_Emp    AS NomValidDir,
                      validDir.Prenom_Emp AS PrenomValidDir')
            ->join('employe',      'employe.id_Emp = absence.id_Emp',               'left')
            ->join('direction',    'direction.id_Dir = employe.id_Dir',             'left')
            ->join('type_absence', 'type_absence.id_TAbs = absence.id_TAbs',        'left')
            ->join('employe validRH',  'validRH.id_Emp  = absence.id_Emp_ValidRH',  'left')
            ->join('employe validDir', 'validDir.id_Emp = absence.id_Emp_ValidDir', 'left')
            ->where('absence.id_Abs', $id)
            ->get()->getRowArray();

        if (!$absence) {
            return redirect()->to('absence')->with('error', 'Absence introuvable.');
        }

        if ($idPfl == 3 && $absence['id_Emp'] != $idEmp) {
            return redirect()->to('absence')->with('error', 'Accès refusé.');
        }

        if ($idPfl == 2) {
            $emp = (new EmployeModel())->find($idEmp);
            if ($absence['id_Emp'] != $idEmp && $absence['id_Dir'] != $emp['id_Dir']) {
                return redirect()->to('absence')->with('error', 'Accès refusé.');
            }
        }

        // Pièces avec valideur
        $pieces = $db->table('piece_justificative')
            ->select('piece_justificative.*,
                      validPJ.Nom_Emp AS NomValidPJ, validPJ.Prenom_Emp AS PrenomValidPJ')
            ->join('employe validPJ', 'validPJ.id_Emp = piece_justificative.id_Emp_ValidPJ', 'left')
            ->where('id_Abs', $id)
            ->orderBy('DateDepot_PJ', 'DESC')
            ->get()->getResultArray();

        $estJustifiee = !empty(array_filter($pieces, fn($p) => $p['Statut_PJ'] === 'validee'));

        $data['title']        = 'Détail Absence';
        $data['absence']      = $absence;
        $data['pieces']       = $pieces;
        $data['estJustifiee'] = $estJustifiee;
        $data['idPfl']        = $idPfl;
        $data['idEmp']        = $idEmp;

        return view('rh/absence/show', $data);
    }

    // ── CREATE ────────────────────────────────────────────────
    public function create()
    {
        $idPfl = $this->idPfl();

        $data['title']        = 'Déclarer une Absence';
        $data['typesAbsence'] = (new TypeAbsenceModel())->findAll();
        $data['idPfl']        = $idPfl;

        if ($idPfl == 1) {
            $data['employes'] = (new EmployeModel())->findAll();
        }

        return view('rh/absence/create', $data);
    }

    // ── STORE ─────────────────────────────────────────────────
    public function store()
    {
        $idPfl = $this->idPfl();
        $idEmp = $this->idEmp();

        $rules = [
            'id_TAbs'       => 'required',
            'DateDebut_Abs' => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()
                             ->with('errors', $this->validator->getErrors());
        }

        $debut = $this->request->getPost('DateDebut_Abs');
        $fin   = $this->request->getPost('DateFin_Abs');

        if ($fin && $fin < $debut) {
            return redirect()->back()->withInput()
                             ->with('error', 'La date de fin doit être après la date de début.');
        }

        $idEmpCible = ($idPfl == 1 && $this->request->getPost('id_Emp'))
            ? (int) $this->request->getPost('id_Emp')
            : $idEmp;

        $demandeur = (new EmployeModel())->find($idEmpCible);

        // RH déclare pour lui-même → statut valide_rh directement
        $statutInitial      = 'en_attente';
        $idValidRH          = null;
        $dateValidationRH   = null;

        if ($idEmpCible == $idEmp && $idPfl == 1) {
            $statutInitial    = 'valide_rh';
            $idValidRH        = $idEmp;
            $dateValidationRH = date('Y-m-d H:i:s');
        }

        $id = $this->model->insert([
            'id_TAbs'              => $this->request->getPost('id_TAbs'),
            'DateDemande_Abs'      => date('Y-m-d'),
            'DateDebut_Abs'        => $debut,
            'DateFin_Abs'          => $fin ?: null,
            'Motif_Abs'            => $this->request->getPost('Motif_Abs'),
            'Rapport_Abs'          => $this->request->getPost('Rapport_Abs'),
            'Statut_Abs'           => $statutInitial,
            'id_Emp'               => $idEmpCible,
            'id_Emp_ValidRH'       => $idValidRH,
            'DateValidationRH_Abs' => $dateValidationRH,
        ]);

        $lien = base_url('absence/show/' . $id);

        // Employé → notifier les RH
        if ($idPfl == 3) {
            $this->notif->envoyerMultiple(
                $this->getRHIds(),
                'Nouvelle déclaration d\'absence',
                $demandeur['Nom_Emp'] . ' ' . $demandeur['Prenom_Emp']
                . ' a déclaré une absence du '
                . date('d/m/Y', strtotime($debut))
                . ($fin ? ' au ' . date('d/m/Y', strtotime($fin)) : '') . '.',
                'absence', $lien, $idEmp
            );
        }

        // RH pour lui-même → notifier les Chefs
        if ($idPfl == 1 && $idEmpCible == $idEmp) {
            $this->notif->envoyerMultiple(
                $this->getChefIds(),
                'Absence RH à approuver',
                $demandeur['Nom_Emp'] . ' ' . $demandeur['Prenom_Emp']
                . ' (RH) a déclaré une absence du '
                . date('d/m/Y', strtotime($debut))
                . ($fin ? ' au ' . date('d/m/Y', strtotime($fin)) : '')
                . '. Elle est prête pour votre approbation.',
                'absence', $lien, $idEmp
            );
        }

        // RH déclare pour un autre employé → notifier les RH + l'employé
        if ($idPfl == 1 && $idEmpCible != $idEmp) {
            $this->notif->envoyerMultiple(
                $this->getRHIds(),
                'Nouvelle déclaration d\'absence',
                $demandeur['Nom_Emp'] . ' ' . $demandeur['Prenom_Emp']
                . ' a déclaré une absence du '
                . date('d/m/Y', strtotime($debut))
                . ($fin ? ' au ' . date('d/m/Y', strtotime($fin)) : '') . '.',
                'absence', $lien, $idEmp
            );
            $this->notif->envoyer(
                $idEmpCible,
                'Une absence a été déclarée pour vous',
                'Le RH a enregistré une absence en votre nom du '
                . date('d/m/Y', strtotime($debut))
                . ($fin ? ' au ' . date('d/m/Y', strtotime($fin)) : '') . '.',
                'absence', $lien, $idEmp
            );
        }

        // Chef → notifier les RH
        if ($idPfl == 2) {
            $this->notif->envoyerMultiple(
                $this->getRHIds(),
                'Absence — Chef de Direction',
                $demandeur['Nom_Emp'] . ' ' . $demandeur['Prenom_Emp']
                . ' (Chef de Direction) a déclaré une absence du '
                . date('d/m/Y', strtotime($debut))
                . ($fin ? ' au ' . date('d/m/Y', strtotime($fin)) : '') . '.',
                'absence', $lien, $idEmp
            );
        }

        $this->log->insert([
            'Action_Log'      => 'CREATE',
            'Module_Log'      => 'Absence',
            'Description_Log' => 'Déclaration absence ID : ' . $id,
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => $idEmp,
        ]);

        return redirect()->to('absence/show/' . $id)
                         ->with('success', 'Absence déclarée avec succès.');
    }

    // ── EDIT ──────────────────────────────────────────────────
    public function edit($id)
    {
        $idPfl   = $this->idPfl();
        $idEmp   = $this->idEmp();
        $absence = $this->model->find($id);

        if (!$absence) {
            return redirect()->to('absence')->with('error', 'Absence introuvable.');
        }

        if ($absence['id_Emp'] != $idEmp) {
            return redirect()->to('absence')->with('error', 'Accès refusé.');
        }

        if ($absence['Statut_Abs'] != 'en_attente') {
            return redirect()->to('absence')
                             ->with('error', 'Impossible de modifier une absence déjà traitée.');
        }

        $data['title']        = 'Modifier l\'Absence';
        $data['absence']      = $absence;
        $data['typesAbsence'] = (new TypeAbsenceModel())->findAll();
        $data['idPfl']        = $idPfl;

        return view('rh/absence/edit', $data);
    }

    // ── UPDATE ────────────────────────────────────────────────
    public function update($id)
    {
        $idEmp   = $this->idEmp();
        $absence = $this->model->find($id);

        if (!$absence) {
            return redirect()->to('absence')->with('error', 'Absence introuvable.');
        }

        if ($absence['id_Emp'] != $idEmp) {
            return redirect()->to('absence')->with('error', 'Accès refusé.');
        }

        if ($absence['Statut_Abs'] != 'en_attente') {
            return redirect()->to('absence')
                             ->with('error', 'Impossible de modifier une absence déjà traitée.');
        }

        $debut = $this->request->getPost('DateDebut_Abs');
        $fin   = $this->request->getPost('DateFin_Abs');

        if ($fin && $fin < $debut) {
            return redirect()->back()->withInput()
                             ->with('error', 'La date de fin doit être après la date de début.');
        }

        $this->model->update($id, [
            'id_TAbs'       => $this->request->getPost('id_TAbs'),
            'DateDebut_Abs' => $debut,
            'DateFin_Abs'   => $fin ?: null,
            'Motif_Abs'     => $this->request->getPost('Motif_Abs'),
            'Rapport_Abs'   => $this->request->getPost('Rapport_Abs'),
        ]);

        $this->log->insert([
            'Action_Log'      => 'UPDATE',
            'Module_Log'      => 'Absence',
            'Description_Log' => 'Modification absence ID : ' . $id,
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => $idEmp,
        ]);

        return redirect()->to('absence/show/' . $id)
                         ->with('success', 'Absence modifiée avec succès.');
    }

    // ── DELETE ────────────────────────────────────────────────
    public function delete($id)
    {
        $idEmp   = $this->idEmp();
        $idPfl   = $this->idPfl();
        $absence = $this->model->find($id);

        if (!$absence) {
            return redirect()->to('absence')->with('error', 'Absence introuvable.');
        }

        if ($absence['id_Emp'] != $idEmp) {
            return redirect()->to('absence')->with('error', 'Accès refusé.');
        }

        if ($absence['Statut_Abs'] != 'en_attente') {
            return redirect()->to('absence')
                             ->with('error', 'Impossible de supprimer une absence déjà traitée.');
        }

        $this->model->delete($id);

        $this->log->insert([
            'Action_Log'      => 'DELETE',
            'Module_Log'      => 'Absence',
            'Description_Log' => 'Suppression absence ID : ' . $id,
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => $idEmp,
        ]);

        return redirect()->to('absence')
                         ->with('success', 'Absence supprimée.');
    }

    // ══════════════════════════════════════════════════════════
    // WORKFLOW RH — étape 1
    // ══════════════════════════════════════════════════════════

    public function validerRH($id)
    {
        if ($this->idPfl() != 1) {
            return redirect()->to('absence')->with('error', 'Accès refusé.');
        }

        $absence = $this->model->find($id);

        if (!$absence || $absence['Statut_Abs'] != 'en_attente') {
            return redirect()->to('absence')->with('error', 'Action impossible.');
        }

        if ($absence['id_Emp'] == $this->idEmp()) {
            return redirect()->to('absence')
                             ->with('error', 'Vous ne pouvez pas valider votre propre absence.');
        }

        $this->model->update($id, [
            'Statut_Abs'           => 'valide_rh',
            'DateValidationRH_Abs' => date('Y-m-d H:i:s'),
            'CommentaireRH_Abs'    => $this->request->getPost('commentaire'),
            'id_Emp_ValidRH'       => $this->idEmp(),
        ]);

        $employe = (new EmployeModel())->find($absence['id_Emp']);
        $lien    = base_url('absence/show/' . $id);

        // Notifier les Chefs
        $this->notif->envoyerMultiple(
            $this->getChefIds(),
            'Absence à approuver',
            'L\'absence de ' . $employe['Nom_Emp'] . ' ' . $employe['Prenom_Emp']
            . ' a été validée par le RH et attend votre approbation.',
            'absence', $lien, $this->idEmp()
        );

        // Notifier l'employé
        $this->notif->envoyer(
            $absence['id_Emp'],
            'Votre absence est en cours de traitement',
            'Votre déclaration d\'absence a été validée par le RH '
            . 'et transmise à votre Chef de Direction.',
            'absence', $lien, $this->idEmp()
        );

        $this->log->insert([
            'Action_Log'      => 'VALIDATE_RH',
            'Module_Log'      => 'Absence',
            'Description_Log' => 'Validation RH absence ID : ' . $id,
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => $this->idEmp(),
        ]);

        return redirect()->to('absence/show/' . $id)
                         ->with('success', 'Absence validée et transmise au Chef de Direction.');
    }

    public function rejeterRH($id)
    {
        if ($this->idPfl() != 1) {
            return redirect()->to('absence')->with('error', 'Accès refusé.');
        }

        $absence = $this->model->find($id);

        if (!$absence || $absence['Statut_Abs'] != 'en_attente') {
            return redirect()->to('absence')->with('error', 'Action impossible.');
        }

        if ($absence['id_Emp'] == $this->idEmp()) {
            return redirect()->to('absence')
                             ->with('error', 'Vous ne pouvez pas rejeter votre propre absence.');
        }

        $commentaire = $this->request->getPost('commentaire');

        if (empty($commentaire)) {
            return redirect()->back()->with('error', 'Un motif de rejet est obligatoire.');
        }

        $this->model->update($id, [
            'Statut_Abs'           => 'rejete_rh',
            'DateValidationRH_Abs' => date('Y-m-d H:i:s'),
            'CommentaireRH_Abs'    => $commentaire,
            'id_Emp_ValidRH'       => $this->idEmp(),
        ]);

        $lien = base_url('absence/show/' . $id);

        $this->notif->envoyer(
            $absence['id_Emp'],
            'Votre déclaration d\'absence a été rejetée',
            'Votre déclaration d\'absence a été rejetée par le RH. Motif : ' . $commentaire,
            'absence', $lien, $this->idEmp()
        );

        $this->log->insert([
            'Action_Log'      => 'REJECT_RH',
            'Module_Log'      => 'Absence',
            'Description_Log' => 'Rejet RH absence ID : ' . $id . ' — ' . $commentaire,
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => $this->idEmp(),
        ]);

        return redirect()->to('absence/show/' . $id)
                         ->with('success', 'Absence rejetée. L\'employé a été notifié.');
    }

    // ══════════════════════════════════════════════════════════
    // WORKFLOW CHEF — étape 2
    // ══════════════════════════════════════════════════════════

    public function approuver($id)
    {
        if ($this->idPfl() != 2) {
            return redirect()->to('absence')->with('error', 'Accès refusé.');
        }

        $absence = $this->model->find($id);

        if (!$absence || $absence['Statut_Abs'] != 'valide_rh') {
            return redirect()->to('absence')->with('error', 'Action impossible.');
        }

        if ($absence['id_Emp'] == $this->idEmp()) {
            return redirect()->to('absence')
                             ->with('error', 'Vous ne pouvez pas approuver votre propre absence.');
        }

        $this->model->update($id, [
            'Statut_Abs'          => 'approuve',
            'DateDecisionDir_Abs' => date('Y-m-d H:i:s'),
            'CommentaireDir_Abs'  => $this->request->getPost('commentaire'),
            'id_Emp_ValidDir'     => $this->idEmp(),
        ]);

        $employe = (new EmployeModel())->find($absence['id_Emp']);
        $lien    = base_url('absence/show/' . $id);

        // Notifier l'employé
        $this->notif->envoyer(
            $absence['id_Emp'],
            'Votre absence a été approuvée',
            'Votre déclaration d\'absence du '
            . date('d/m/Y', strtotime($absence['DateDebut_Abs']))
            . ($absence['DateFin_Abs'] ? ' au ' . date('d/m/Y', strtotime($absence['DateFin_Abs'])) : '')
            . ' a été approuvée par votre Chef de Direction.',
            'absence', $lien, $this->idEmp()
        );

        // Notifier les RH
        $this->notif->envoyerMultiple(
            $this->getRHIds(),
            'Absence approuvée',
            'L\'absence de ' . $employe['Nom_Emp'] . ' ' . $employe['Prenom_Emp']
            . ' a été approuvée par le Chef de Direction.',
            'absence', $lien, $this->idEmp()
        );

        $this->log->insert([
            'Action_Log'      => 'APPROVE',
            'Module_Log'      => 'Absence',
            'Description_Log' => 'Approbation absence ID : ' . $id,
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => $this->idEmp(),
        ]);

        return redirect()->to('absence/show/' . $id)
                         ->with('success', 'Absence approuvée. L\'employé et le RH ont été notifiés.');
    }

    public function refuser($id)
    {
        if ($this->idPfl() != 2) {
            return redirect()->to('absence')->with('error', 'Accès refusé.');
        }

        $absence = $this->model->find($id);

        if (!$absence || $absence['Statut_Abs'] != 'valide_rh') {
            return redirect()->to('absence')->with('error', 'Action impossible.');
        }

        if ($absence['id_Emp'] == $this->idEmp()) {
            return redirect()->to('absence')
                             ->with('error', 'Vous ne pouvez pas refuser votre propre absence.');
        }

        $commentaire = $this->request->getPost('commentaire');

        if (empty($commentaire)) {
            return redirect()->back()->with('error', 'Un motif de refus est obligatoire.');
        }

        $this->model->update($id, [
            'Statut_Abs'          => 'rejete',
            'DateDecisionDir_Abs' => date('Y-m-d H:i:s'),
            'CommentaireDir_Abs'  => $commentaire,
            'id_Emp_ValidDir'     => $this->idEmp(),
        ]);

        $employe = (new EmployeModel())->find($absence['id_Emp']);
        $lien    = base_url('absence/show/' . $id);

        // Notifier l'employé
        $this->notif->envoyer(
            $absence['id_Emp'],
            'Votre absence a été refusée',
            'Votre déclaration d\'absence a été refusée par votre Chef de Direction. Motif : ' . $commentaire,
            'absence', $lien, $this->idEmp()
        );

        // Notifier les RH
        $this->notif->envoyerMultiple(
            $this->getRHIds(),
            'Absence refusée',
            'L\'absence de ' . $employe['Nom_Emp'] . ' ' . $employe['Prenom_Emp']
            . ' a été refusée par le Chef de Direction. Motif : ' . $commentaire,
            'absence', $lien, $this->idEmp()
        );

        $this->log->insert([
            'Action_Log'      => 'REJECT',
            'Module_Log'      => 'Absence',
            'Description_Log' => 'Refus absence ID : ' . $id . ' — ' . $commentaire,
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => $this->idEmp(),
        ]);

        return redirect()->to('absence/show/' . $id)
                         ->with('success', 'Absence refusée. L\'employé et le RH ont été notifiés.');
    }

    // ══════════════════════════════════════════════════════════
    // PIÈCES JUSTIFICATIVES
    // ══════════════════════════════════════════════════════════

    public function ajouterPJ($id)
    {
        $idEmp   = $this->idEmp();
        $idPfl   = $this->idPfl();
        $absence = $this->model->find($id);

        if (!$absence) {
            return redirect()->to('absence')->with('error', 'Absence introuvable.');
        }

        if ($idPfl == 3 && $absence['id_Emp'] != $idEmp) {
            return redirect()->to('absence')->with('error', 'Accès refusé.');
        }

        $fichier = $this->request->getFile('piece_justificative');

        if (!$fichier || !$fichier->isValid() || $fichier->hasMoved()) {
            return redirect()->back()->with('error', 'Fichier invalide ou manquant.');
        }

        $ext     = $fichier->getClientExtension();
        $allowed = ['pdf', 'jpg', 'jpeg', 'png'];

        if (!in_array(strtolower($ext), $allowed)) {
            return redirect()->back()->with('error', 'Format non autorisé. PDF, JPG ou PNG uniquement.');
        }

        if ($fichier->getSize() > 5 * 1024 * 1024) {
            return redirect()->back()->with('error', 'Fichier trop volumineux (max 5 Mo).');
        }

        $newName = $fichier->getRandomName();
        $fichier->move(WRITEPATH . 'uploads/absences', $newName);

        // RH → validée automatiquement | Employé/Chef → en_attente
        $statutPJ       = ($idPfl == 1) ? 'validee'        : 'en_attente';
        $dateValidation = ($idPfl == 1) ? date('Y-m-d H:i:s') : null;
        $idValidPJ      = ($idPfl == 1) ? $idEmp           : null;

        (new PieceJustificativeModel())->insert([
            'CheminFichier_PJ'  => 'uploads/absences/' . $newName,
            'DateDepot_PJ'      => date('Y-m-d'),
            'Statut_PJ'         => $statutPJ,
            'DateValidation_PJ' => $dateValidation,
            'id_Abs'            => $id,
            'id_Emp_ValidPJ'    => $idValidPJ,
        ]);

        if ($idPfl != 1) {
            $employe = (new EmployeModel())->find($idEmp);
            $lien    = base_url('absence/show/' . $id);
            $this->notif->envoyerMultiple(
                $this->getRHIds(),
                'Pièce justificative à valider',
                $employe['Nom_Emp'] . ' ' . $employe['Prenom_Emp']
                . ' a déposé une pièce justificative pour son absence. Veuillez la valider.',
                'absence', $lien, $idEmp
            );
        }

        $this->log->insert([
            'Action_Log'      => 'ADD_PJ',
            'Module_Log'      => 'Absence',
            'Description_Log' => 'Ajout PJ absence ID : ' . $id,
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => $idEmp,
        ]);

        $msg = ($idPfl == 1)
            ? 'Pièce justificative ajoutée et validée. L\'absence est désormais justifiée.'
            : 'Pièce justificative déposée. En attente de validation par le RH.';

        return redirect()->to('absence/show/' . $id)->with('success', $msg);
    }

    public function validerPJ($idPJ)
    {
        if ($this->idPfl() != 1) {
            return redirect()->to('absence')->with('error', 'Accès refusé.');
        }

        $pjModel = new PieceJustificativeModel();
        $pj      = $pjModel->find($idPJ);

        if (!$pj || $pj['Statut_PJ'] != 'en_attente') {
            return redirect()->back()->with('error', 'Action impossible.');
        }

        $pjModel->update($idPJ, [
            'Statut_PJ'         => 'validee',
            'DateValidation_PJ' => date('Y-m-d H:i:s'),
            'id_Emp_ValidPJ'    => $this->idEmp(),
        ]);

        $absence = $this->model->find($pj['id_Abs']);
        $lien    = base_url('absence/show/' . $pj['id_Abs']);

        $this->notif->envoyer(
            $absence['id_Emp'],
            'Votre pièce justificative a été validée',
            'Votre pièce justificative a été validée par le RH. Votre absence est désormais justifiée.',
            'absence', $lien, $this->idEmp()
        );

        $this->log->insert([
            'Action_Log'      => 'VALIDATE_PJ',
            'Module_Log'      => 'Absence',
            'Description_Log' => 'Validation PJ ID : ' . $idPJ . ' — absence ID : ' . $pj['id_Abs'],
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => $this->idEmp(),
        ]);

        return redirect()->to('absence/show/' . $pj['id_Abs'])
                         ->with('success', 'Pièce justificative validée. L\'absence est désormais justifiée.');
    }

    public function rejeterPJ($idPJ)
    {
        if ($this->idPfl() != 1) {
            return redirect()->to('absence')->with('error', 'Accès refusé.');
        }

        $pjModel = new PieceJustificativeModel();
        $pj      = $pjModel->find($idPJ);

        if (!$pj || $pj['Statut_PJ'] != 'en_attente') {
            return redirect()->back()->with('error', 'Action impossible.');
        }

        $commentaire = $this->request->getPost('commentaire');

        if (empty($commentaire)) {
            return redirect()->back()->with('error', 'Un motif de rejet est obligatoire.');
        }

        $pjModel->update($idPJ, [
            'Statut_PJ'           => 'rejetee',
            'DateValidation_PJ'   => date('Y-m-d H:i:s'),
            'CommentaireRejet_PJ' => $commentaire,
            'id_Emp_ValidPJ'      => $this->idEmp(),
        ]);

        $absence = $this->model->find($pj['id_Abs']);
        $lien    = base_url('absence/show/' . $pj['id_Abs']);

        $this->notif->envoyer(
            $absence['id_Emp'],
            'Votre pièce justificative a été rejetée',
            'Votre pièce justificative a été rejetée par le RH. Motif : ' . $commentaire
            . '. Vous pouvez en déposer une nouvelle.',
            'absence', $lien, $this->idEmp()
        );

        $this->log->insert([
            'Action_Log'      => 'REJECT_PJ',
            'Module_Log'      => 'Absence',
            'Description_Log' => 'Rejet PJ ID : ' . $idPJ . ' — ' . $commentaire,
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => $this->idEmp(),
        ]);

        return redirect()->to('absence/show/' . $pj['id_Abs'])
                         ->with('success', 'Pièce justificative rejetée. L\'employé a été notifié.');
    }
}