<?php

namespace App\Controllers;

use App\Models\NotificationModel;
use App\Models\ActivityLogModel;
use App\Models\EmployeModel;

class FormationController extends BaseController
{
    protected $notif;
    protected $log;

    public function __construct()
    {
        $this->notif = new NotificationModel();
        $this->log   = new ActivityLogModel();
    }

    private function idEmp(): int { return (int) session()->get('id_Emp'); }
    private function idPfl(): int { return (int) session()->get('id_Pfl'); }

    private function profileView(string $page, array $data = []): string
    {
        $folder = match ($this->idPfl()) {
            1       => 'rh',
            2       => 'chef',
            3       => 'employe',
            default => 'employe',
        };
        return view("{$folder}/formation/{$page}", $data);
    }

    private function getRHIds(): array
    {
        $db = \Config\Database::connect();
        return array_column(
            $db->table('employe')->where('id_Pfl', 1)->get()->getResultArray(),
            'id_Emp'
        );
    }

    private function getChefsDirIds(int $idDir): array
    {
        $db = \Config\Database::connect();
        return array_column(
            $db->table('employe')
               ->where('id_Pfl', 2)
               ->where('id_Dir', $idDir)
               ->get()->getResultArray(),
            'id_Emp'
        );
    }

    // ── Helper : direction du Chef connecté ───────────────────
    private function getIdDirChef(): int
    {
        $chef = (new EmployeModel())->find($this->idEmp());
        return (int) ($chef['id_Dir'] ?? 0);
    }

    // ── Helper : données communes pour create/edit (Chef) ─────
    private function getFormData(): array
    {
        $db = \Config\Database::connect();
        $idDir = $this->getIdDirChef();

        $directions = $db->table('direction')
            ->select('direction.id_Dir, direction.Nom_Dir,
                      COUNT(employe.id_Emp) AS nb_employes')
            ->join('employe', 'employe.id_Dir = direction.id_Dir', 'left')
            ->groupBy('direction.id_Dir')
            ->orderBy('direction.Nom_Dir')
            ->get()->getResultArray();

        $competences = $db->table('competence')
            ->orderBy('Libelle_Cmp', 'ASC')
            ->get()->getResultArray();

        $grades = $db->table('grade')
            ->orderBy('Libelle_Grd', 'ASC')
            ->get()->getResultArray();

        // Pour les invitations — Chef voit sa direction,
        // on charge tous les employés profil 3
        $empQuery = $db->table('employe')
            ->select('employe.id_Emp, employe.Nom_Emp, employe.Prenom_Emp,
                      employe.id_Pfl, employe.id_Dir, employe.id_Grd,
                      direction.Nom_Dir, grade.Libelle_Grd')
            ->join('direction', 'direction.id_Dir = employe.id_Dir', 'left')
            ->join('grade',     'grade.id_Grd = employe.id_Grd',     'left')
            ->where('employe.id_Pfl', 3)
            ->orderBy('employe.Nom_Emp');

        // Chef → uniquement sa direction
        if ($this->idPfl() == 2 && $idDir) {
            $empQuery->where('employe.id_Dir', $idDir);
        }

        $employes = $empQuery->get()->getResultArray();

        return compact('directions', 'competences', 'grades', 'employes');
    }

    // ══════════════════════════════════════════════════════════
    // INDEX — tous les profils
    // ══════════════════════════════════════════════════════════
    public function index()
    {
        $db    = \Config\Database::connect();
        $idPfl = $this->idPfl();
        $idEmp = $this->idEmp();

        $formations = $db->table('formation')
            ->orderBy('DateDebut_Frm', 'DESC')
            ->get()->getResultArray();

        foreach ($formations as &$f) {
            $f['nb_valides'] = $db->table('s_inscrire')
                ->where('id_Frm', $f['id_Frm'])
                ->where('Stt_Ins', 'valide')
                ->countAllResults();

            $f['nb_invites'] = $db->table('s_inscrire')
                ->where('id_Frm', $f['id_Frm'])
                ->where('Stt_Ins', 'invite')
                ->countAllResults();

            $f['mon_inscription'] = $db->table('s_inscrire')
                ->where('id_Frm', $f['id_Frm'])
                ->where('id_Emp', $idEmp)
                ->get()->getRowArray();

            $f['places_restantes'] = max(0, $f['Capacite_Frm'] - $f['nb_valides']);
        }
        unset($f);

        return $this->profileView('index', [
            'title'      => 'Formations',
            'formations' => $formations,
            'idPfl'      => $idPfl,
            'idEmp'      => $idEmp,
        ]);
    }

    // ══════════════════════════════════════════════════════════
    // SHOW — tous les profils
    // ══════════════════════════════════════════════════════════
    public function show($id)
    {
        $db    = \Config\Database::connect();
        $idPfl = $this->idPfl();
        $idEmp = $this->idEmp();

        $formation = $db->table('formation')
            ->where('id_Frm', $id)
            ->get()->getRowArray();

        if (!$formation) {
            return redirect()->to('formation')->with('error', 'Formation introuvable.');
        }

        $participants = $db->table('s_inscrire')
            ->select('s_inscrire.*, employe.Nom_Emp, employe.Prenom_Emp,
                      employe.Email_Emp, direction.Nom_Dir, direction.id_Dir')
            ->join('employe',   'employe.id_Emp = s_inscrire.id_Emp', 'left')
            ->join('direction', 'direction.id_Dir = employe.id_Dir',  'left')
            ->where('s_inscrire.id_Frm', $id)
            ->orderBy('s_inscrire.Stt_Ins')
            ->get()->getResultArray();

        $nbValides = count(array_filter($participants, fn($p) => $p['Stt_Ins'] === 'valide'));
        $nbInvites = count(array_filter($participants, fn($p) => $p['Stt_Ins'] === 'invite'));
        $nbAnnules = count(array_filter($participants, fn($p) => $p['Stt_Ins'] === 'annule'));

        $monInscription = $db->table('s_inscrire')
            ->where('id_Frm', $id)
            ->where('id_Emp', $idEmp)
            ->get()->getRowArray();

        $placesRestantes = max(0, $formation['Capacite_Frm'] - $nbValides);

        // ── Compétences prévues + confirmées (relation tertiaire) ──
        $competencesObtenues = $db->table('obtenir o')
            ->select('o.*, c.Libelle_Cmp, e.Nom_Emp, e.Prenom_Emp,
                      e.id_Dir, d.Nom_Dir')
            ->join('competence c', 'c.id_Cmp = o.id_Cmp')
            ->join('employe e',    'e.id_Emp = o.id_Emp',  'left')
            ->join('direction d',  'd.id_Dir = e.id_Dir',  'left')
            ->where('o.id_Frm', $id)
            ->orderBy('c.Libelle_Cmp')
            ->orderBy('e.Nom_Emp')
            ->get()->getResultArray();

        // ── Données Chef ──────────────────────────────────────
        $competences         = [];
        $participantsDirChef = [];

        if ($idPfl == 2) {
            $idDir = $this->getIdDirChef();

            $competences = $db->table('competence')
                ->orderBy('Libelle_Cmp', 'ASC')
                ->get()->getResultArray();

            $participantsDirChef = array_values(array_filter(
                $participants,
                fn($p) => isset($p['id_Dir'])
                    && $p['id_Dir'] == $idDir
                    && $p['Stt_Ins'] === 'valide'
            ));
        }

        // ── Employés disponibles pour invitation (RH + Chef) ──
        $employesDisponibles = [];

        if ($idPfl == 1 || $idPfl == 2) {
            $inscritsIds = array_column($participants, 'id_Emp');

            $invQuery = $db->table('employe')
                ->select('employe.id_Emp, employe.Nom_Emp, employe.Prenom_Emp,
                          employe.Email_Emp, direction.Nom_Dir, direction.id_Dir')
                ->join('direction', 'direction.id_Dir = employe.id_Dir', 'left')
                ->where('employe.id_Pfl', 3);

            // Chef → uniquement sa direction
            if ($idPfl == 2) {
                $invQuery->where('employe.id_Dir', $this->getIdDirChef());
            }

            if (!empty($inscritsIds)) {
                $invQuery->whereNotIn('employe.id_Emp', $inscritsIds);
            }

            $employesDisponibles = $invQuery->orderBy('employe.Nom_Emp')
                                            ->get()->getResultArray();
        }

        return $this->profileView('show', [
            'title'               => 'Détail Formation',
            'formation'           => $formation,
            'participants'        => $participants,
            'participantsDirChef' => $participantsDirChef,
            'nbValides'           => $nbValides,
            'nbInvites'           => $nbInvites,
            'nbAnnules'           => $nbAnnules,
            'monInscription'      => $monInscription,
            'competences'         => $competences,
            'competencesObtenues' => $competencesObtenues,
            'employesDisponibles' => $employesDisponibles,
            'placesRestantes'     => $placesRestantes,
            'idPfl'               => $idPfl,
            'idEmp'               => $idEmp,
        ]);
    }

    // ══════════════════════════════════════════════════════════
    // CREATE — Chef uniquement
    // ══════════════════════════════════════════════════════════
    public function create()
    {
        if ($this->idPfl() != 2) {
            return redirect()->to('formation')->with('error', 'Accès refusé.');
        }

        return view('chef/formation/create', array_merge(
            $this->getFormData(),
            ['title' => 'Nouvelle formation', 'idPfl' => $this->idPfl()]
        ));
    }

    // ══════════════════════════════════════════════════════════
    // STORE — Chef uniquement
    // ══════════════════════════════════════════════════════════
    public function store()
    {
        if ($this->idPfl() != 2) {
            return redirect()->to('formation')->with('error', 'Accès refusé.');
        }

        $rules = [
            'Titre_Frm'       => 'required|min_length[3]',
            'Description_Frm' => 'required|min_length[5]',
            'DateDebut_Frm'   => 'required',
            'DateFin_Frm'     => 'required',
            'Lieu_Frm'        => 'required',
            'Formateur_Frm'   => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()
                             ->with('errors', $this->validator->getErrors());
        }

        $debut = $this->request->getPost('DateDebut_Frm');
        $fin   = $this->request->getPost('DateFin_Frm');

        if ($fin < $debut) {
            return redirect()->back()->withInput()
                             ->with('error', 'La date de fin doit être après la date de début.');
        }

        $optionCapacite = $this->request->getPost('option_capacite');
        $idDirCapacite  = (int) $this->request->getPost('id_Dir_capacite');
        $db             = \Config\Database::connect();

        if ($optionCapacite === 'tous' && $idDirCapacite) {
            $capacite = $db->table('employe')
                ->where('id_Dir', $idDirCapacite)
                ->where('id_Pfl', 3)
                ->countAllResults();
        } else {
            $capacite = (int) $this->request->getPost('Capacite_Frm');
        }

        if ($capacite <= 0) {
            return redirect()->back()->withInput()
                             ->with('error', 'La capacité doit être supérieure à 0.');
        }

        $titre = $this->request->getPost('Titre_Frm');

        $db->table('formation')->insert([
            'Titre_Frm'       => $titre,
            'Description_Frm' => $this->request->getPost('Description_Frm'),
            'DateDebut_Frm'   => $debut,
            'DateFin_Frm'     => $fin,
            'Lieu_Frm'        => $this->request->getPost('Lieu_Frm'),
            'Formateur_Frm'   => $this->request->getPost('Formateur_Frm'),
            'Capacite_Frm'    => $capacite,
            'Statut_Frm'      => 'planifiee',
        ]);

        $newId = $db->insertID();
        $lien  = base_url('formation/show/' . $newId);

        // ── Compétences prévues (id_Emp = NULL) ──
        $competences = array_filter(
            array_map('intval', (array) ($this->request->getPost('competences') ?? [])),
            fn($v) => $v > 0
        );

        foreach ($competences as $idCmp) {
            $db->table('obtenir')->insert([
                'id_Emp'     => null,
                'id_Cmp'     => $idCmp,
                'id_Frm'     => $newId,
                'Niveau_Obt' => null,
                'Dte_Obt'    => null,
            ]);
        }

        // ── Invitations ──
        $invMode = $this->request->getPost('inv_mode') ?? 'aucun';
        $empIds  = [];

        if ($invMode === 'entreprise') {
            $empIds = array_column(
                $db->table('employe')->where('id_Pfl', 3)->get()->getResultArray(),
                'id_Emp'
            );
        } elseif ($invMode === 'direction') {
            $dirIds = array_filter(
                array_map('intval', (array) ($this->request->getPost('inv_directions') ?? [])),
                fn($v) => $v > 0
            );
            if (!empty($dirIds)) {
                $empIds = array_column(
                    $db->table('employe')
                       ->where('id_Pfl', 3)
                       ->whereIn('id_Dir', $dirIds)
                       ->get()->getResultArray(),
                    'id_Emp'
                );
            }
        } elseif ($invMode === 'selection') {
            $empIds = array_filter(
                array_map('intval', (array) ($this->request->getPost('inv_employes') ?? [])),
                fn($v) => $v > 0
            );
        }

        $inviteur = $this->idPfl() == 2 ? 'Le Chef de Direction' : 'Le RH';

        foreach ($empIds as $idEmpInvite) {
            $dejaInscrit = $db->table('s_inscrire')
                ->where('id_Frm', $newId)
                ->where('id_Emp', $idEmpInvite)
                ->get()->getRowArray();

            if ($dejaInscrit) continue;

            $db->table('s_inscrire')->insert([
                'id_Frm'  => $newId,
                'id_Emp'  => $idEmpInvite,
                'Stt_Ins' => 'invite',
                'Dte_Ins' => date('Y-m-d'),
            ]);

            $this->notif->envoyer(
                $idEmpInvite,
                'Invitation à une formation',
                $inviteur . ' vous invite à participer à la formation : "' . $titre . '"'
                . ' du ' . date('d/m/Y', strtotime($debut))
                . ' au ' . date('d/m/Y', strtotime($fin))
                . '. Veuillez accepter ou refuser cette invitation.',
                'formation', $lien, $this->idEmp()
            );
        }

        // Notifier le RH de la nouvelle formation créée par le Chef
        if ($this->idPfl() == 2) {
            $chef = (new EmployeModel())->find($this->idEmp());
            $this->notif->envoyerMultiple(
                $this->getRHIds(),
                'Nouvelle formation créée',
                $chef['Nom_Emp'] . ' ' . $chef['Prenom_Emp']
                . ' a créé une nouvelle formation : "' . $titre . '"'
                . ' du ' . date('d/m/Y', strtotime($debut))
                . ' au ' . date('d/m/Y', strtotime($fin)) . '.',
                'formation', $lien, $this->idEmp()
            );
        }

        $this->log->insert([
            'Action_Log'      => 'CREATE',
            'Module_Log'      => 'Formation',
            'Description_Log' => 'Création formation ID : ' . $newId
                               . ' "' . $titre . '"'
                               . ' — ' . count($competences) . ' compétence(s) prévue(s)'
                               . ' — ' . count($empIds) . ' invitation(s) envoyée(s)',
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => $this->idEmp(),
        ]);

        $msg = 'Formation créée avec succès.';
        if (!empty($empIds))      $msg .= ' ' . count($empIds) . ' invitation(s) envoyée(s).';
        if (!empty($competences)) $msg .= ' ' . count($competences) . ' compétence(s) prévue(s).';

        return redirect()->to('formation/show/' . $newId)->with('success', $msg);
    }

    // ══════════════════════════════════════════════════════════
    // EDIT — Chef uniquement
    // ══════════════════════════════════════════════════════════
    public function edit($id)
    {
        if ($this->idPfl() != 2) {
            return redirect()->to('formation')->with('error', 'Accès refusé.');
        }

        $db        = \Config\Database::connect();
        $formation = $db->table('formation')->where('id_Frm', $id)->get()->getRowArray();

        if (!$formation) {
            return redirect()->to('formation')->with('error', 'Formation introuvable.');
        }

        $formation['nb_valides'] = $db->table('s_inscrire')
            ->where('id_Frm', $id)
            ->where('Stt_Ins', 'valide')
            ->countAllResults();

        $competencesObtenues = $db->table('obtenir')
            ->where('id_Frm', $id)
            ->get()->getResultArray();

        return view('chef/formation/edit', array_merge(
            $this->getFormData(),
            [
                'title'               => 'Modifier la formation',
                'formation'           => $formation,
                'competencesObtenues' => $competencesObtenues,
                'idPfl'               => $this->idPfl(),
            ]
        ));
    }

    // ══════════════════════════════════════════════════════════
    // UPDATE — Chef uniquement
    // ══════════════════════════════════════════════════════════
    public function update($id)
    {
        if ($this->idPfl() != 2) {
            return redirect()->to('formation')->with('error', 'Accès refusé.');
        }

        $db        = \Config\Database::connect();
        $formation = $db->table('formation')->where('id_Frm', $id)->get()->getRowArray();

        if (!$formation) {
            return redirect()->to('formation')->with('error', 'Formation introuvable.');
        }

        $rules = [
            'Titre_Frm'       => 'required|min_length[3]',
            'Description_Frm' => 'required|min_length[5]',
            'DateDebut_Frm'   => 'required',
            'DateFin_Frm'     => 'required',
            'Lieu_Frm'        => 'required',
            'Formateur_Frm'   => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()
                             ->with('errors', $this->validator->getErrors());
        }

        $debut = $this->request->getPost('DateDebut_Frm');
        $fin   = $this->request->getPost('DateFin_Frm');

        if ($fin < $debut) {
            return redirect()->back()->withInput()
                             ->with('error', 'La date de fin doit être après la date de début.');
        }

        $optionCapacite = $this->request->getPost('option_capacite');
        $idDirCapacite  = (int) $this->request->getPost('id_Dir_capacite');

        if ($optionCapacite === 'tous' && $idDirCapacite) {
            $capacite = $db->table('employe')
                ->where('id_Dir', $idDirCapacite)
                ->where('id_Pfl', 3)
                ->countAllResults();
        } else {
            $capacite = (int) $this->request->getPost('Capacite_Frm');
        }

        if ($capacite <= 0) {
            return redirect()->back()->withInput()
                             ->with('error', 'La capacité doit être supérieure à 0.');
        }

        $nbValides = $db->table('s_inscrire')
            ->where('id_Frm', $id)
            ->where('Stt_Ins', 'valide')
            ->countAllResults();

        if ($capacite < $nbValides) {
            return redirect()->back()->withInput()
                             ->with('error', 'La capacité ne peut pas être inférieure au nombre de participants confirmés (' . $nbValides . ').');
        }

        $titre = $this->request->getPost('Titre_Frm');

        $db->table('formation')->where('id_Frm', $id)->update([
            'Titre_Frm'       => $titre,
            'Description_Frm' => $this->request->getPost('Description_Frm'),
            'DateDebut_Frm'   => $debut,
            'DateFin_Frm'     => $fin,
            'Lieu_Frm'        => $this->request->getPost('Lieu_Frm'),
            'Formateur_Frm'   => $this->request->getPost('Formateur_Frm'),
            'Capacite_Frm'    => $capacite,
        ]);

        // ── Compétences prévues : reconstruire ──
        $db->table('obtenir')
            ->where('id_Frm', $id)
            ->where('id_Emp IS NULL')
            ->delete();

        $competences = array_filter(
            array_map('intval', (array) ($this->request->getPost('competences') ?? [])),
            fn($v) => $v > 0
        );

        foreach ($competences as $idCmp) {
            $db->table('obtenir')->insert([
                'id_Emp'     => null,
                'id_Cmp'     => $idCmp,
                'id_Frm'     => $id,
                'Niveau_Obt' => null,
                'Dte_Obt'    => null,
            ]);
        }

        // ── Notifier participants valides + invités ──
        $inscrits = $db->table('s_inscrire')
            ->where('id_Frm', $id)
            ->whereIn('Stt_Ins', ['valide', 'invite'])
            ->get()->getResultArray();

        $lien = base_url('formation/show/' . $id);

        foreach ($inscrits as $inscrit) {
            $this->notif->envoyer(
                $inscrit['id_Emp'],
                'Formation modifiée',
                'La formation "' . $titre . '" a été modifiée. '
                . 'Veuillez vérifier les nouvelles dates et informations.',
                'formation', $lien, $this->idEmp()
            );
        }

        // Notifier le RH
        $this->notif->envoyerMultiple(
            $this->getRHIds(),
            'Formation modifiée',
            'La formation "' . $titre . '" a été modifiée par le Chef de Direction.',
            'formation', $lien, $this->idEmp()
        );

        $this->log->insert([
            'Action_Log'      => 'UPDATE',
            'Module_Log'      => 'Formation',
            'Description_Log' => 'Modification formation ID : ' . $id . ' "' . $titre . '"',
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => $this->idEmp(),
        ]);

        return redirect()->to('formation/show/' . $id)
                         ->with('success', 'Formation modifiée avec succès.');
    }

    // ══════════════════════════════════════════════════════════
    // DELETE — Chef uniquement
    // ══════════════════════════════════════════════════════════
    public function delete($id)
    {
        if ($this->idPfl() != 2) {
            return redirect()->to('formation')->with('error', 'Accès refusé.');
        }

        $db        = \Config\Database::connect();
        $formation = $db->table('formation')->where('id_Frm', $id)->get()->getRowArray();

        if (!$formation) {
            return redirect()->to('formation')->with('error', 'Formation introuvable.');
        }

        $nbValides = $db->table('s_inscrire')
            ->where('id_Frm', $id)
            ->where('Stt_Ins', 'valide')
            ->countAllResults();

        if ($nbValides > 0) {
            return redirect()->to('formation/show/' . $id)
                             ->with('error', 'Impossible de supprimer : '
                                 . $nbValides . ' participant(s) confirmé(s).');
        }

        $db->table('s_inscrire')->where('id_Frm', $id)->delete();
        $db->table('obtenir')->where('id_Frm', $id)->delete();
        $db->table('formation')->where('id_Frm', $id)->delete();

        // Notifier le RH
        $this->notif->envoyerMultiple(
            $this->getRHIds(),
            'Formation supprimée',
            'La formation "' . $formation['Titre_Frm'] . '" a été supprimée par le Chef de Direction.',
            'formation', base_url('formation'), $this->idEmp()
        );

        $this->log->insert([
            'Action_Log'      => 'DELETE',
            'Module_Log'      => 'Formation',
            'Description_Log' => 'Suppression formation : "' . $formation['Titre_Frm'] . '"',
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => $this->idEmp(),
        ]);

        return redirect()->to('formation')->with('success', 'Formation supprimée.');
    }

    // ══════════════════════════════════════════════════════════
    // INVITER — RH (profil 1) et Chef (profil 2)
    // ══════════════════════════════════════════════════════════
    public function inviter($id)
    {
        if (!in_array($this->idPfl(), [1, 2])) {
            return redirect()->to('formation/show/' . $id)->with('error', 'Accès refusé.');
        }

        $db          = \Config\Database::connect();
        $idEmp       = $this->idEmp();
        $formation   = $db->table('formation')->where('id_Frm', $id)->get()->getRowArray();

        if (!$formation) {
            return redirect()->to('formation')->with('error', 'Formation introuvable.');
        }

        $idEmpInvite = (int) $this->request->getPost('id_Emp');

        if (!$idEmpInvite) {
            return redirect()->back()->with('error', 'Veuillez sélectionner un employé.');
        }

        // Chef → uniquement sa direction
        if ($this->idPfl() == 2) {
            $idDir   = $this->getIdDirChef();
            $empCible = $db->table('employe')
                ->where('id_Emp', $idEmpInvite)
                ->get()->getRowArray();
            if (!$empCible || (int)$empCible['id_Dir'] !== $idDir) {
                return redirect()->to('formation/show/' . $id)
                                 ->with('error', 'Cet employé n\'est pas dans votre direction.');
            }
        }

        $dejaInscrit = $db->table('s_inscrire')
            ->where('id_Frm', $id)
            ->where('id_Emp', $idEmpInvite)
            ->whereNotIn('Stt_Ins', ['annule'])
            ->get()->getRowArray();

        if ($dejaInscrit) {
            return redirect()->to('formation/show/' . $id)
                             ->with('error', 'Cet employé est déjà inscrit ou invité.');
        }

        $nbValides = $db->table('s_inscrire')
            ->where('id_Frm', $id)
            ->where('Stt_Ins', 'valide')
            ->countAllResults();

        if ($formation['Capacite_Frm'] > 0 && $nbValides >= $formation['Capacite_Frm']) {
            return redirect()->to('formation/show/' . $id)
                             ->with('error', 'La capacité maximale est atteinte. Invitation impossible.');
        }

        $db->table('s_inscrire')->insert([
            'id_Frm'  => $id,
            'id_Emp'  => $idEmpInvite,
            'Stt_Ins' => 'invite',
            'Dte_Ins' => date('Y-m-d'),
        ]);

        $employe  = (new EmployeModel())->find($idEmpInvite);
        $lien     = base_url('formation/show/' . $id);
        $titre    = $formation['Titre_Frm'];
        $inviteur = $this->idPfl() == 2 ? 'Le Chef de Direction' : 'Le RH';

        $this->notif->envoyer(
            $idEmpInvite,
            'Invitation à une formation',
            $inviteur . ' vous invite à participer à la formation : "' . $titre . '"'
            . ' du ' . date('d/m/Y', strtotime($formation['DateDebut_Frm']))
            . ' au ' . date('d/m/Y', strtotime($formation['DateFin_Frm']))
            . '. Veuillez accepter ou refuser cette invitation.',
            'formation', $lien, $idEmp
        );

        $this->log->insert([
            'Action_Log'      => 'INVITATION',
            'Module_Log'      => 'Formation',
            'Description_Log' => 'Invitation formation "' . $titre . '" → employé ID : ' . $idEmpInvite,
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => $idEmp,
        ]);

        return redirect()->to('formation/show/' . $id)
                         ->with('success', 'Invitation envoyée à '
                             . $employe['Prenom_Emp'] . ' ' . $employe['Nom_Emp'] . '.');
    }

    // ══════════════════════════════════════════════════════════
    // ACCEPTER INVITATION — Employé uniquement
    // ══════════════════════════════════════════════════════════
    public function accepterInvitation($id)
    {
        if ($this->idPfl() != 3) {
            return redirect()->to('formation/show/' . $id)->with('error', 'Accès refusé.');
        }

        $db    = \Config\Database::connect();
        $idEmp = $this->idEmp();

        $inscription = $db->table('s_inscrire')
            ->where('id_Frm', $id)
            ->where('id_Emp', $idEmp)
            ->where('Stt_Ins', 'invite')
            ->get()->getRowArray();

        if (!$inscription) {
            return redirect()->to('formation/show/' . $id)
                             ->with('error', 'Aucune invitation en attente pour cette formation.');
        }

        $formation = $db->table('formation')->where('id_Frm', $id)->get()->getRowArray();
        $nbValides = $db->table('s_inscrire')
            ->where('id_Frm', $id)
            ->where('Stt_Ins', 'valide')
            ->countAllResults();

        if ($formation['Capacite_Frm'] > 0 && $nbValides >= $formation['Capacite_Frm']) {
            $db->table('s_inscrire')
                ->where('id_Frm', $id)
                ->where('id_Emp', $idEmp)
                ->update(['Stt_Ins' => 'annule']);

            return redirect()->to('formation/show/' . $id)
                             ->with('error', 'La formation est complète. Votre invitation a été annulée.');
        }

        $db->table('s_inscrire')
            ->where('id_Frm', $id)
            ->where('id_Emp', $idEmp)
            ->update(['Stt_Ins' => 'valide']);

        $employe  = (new EmployeModel())->find($idEmp);
        $lien     = base_url('formation/show/' . $id);
        $titre    = $formation['Titre_Frm'];
        $chefsDir = $this->getChefsDirIds($employe['id_Dir']);

        $this->notif->envoyerMultiple(
            $this->getRHIds(),
            'Invitation acceptée',
            $employe['Prenom_Emp'] . ' ' . $employe['Nom_Emp']
            . ' a accepté l\'invitation à la formation : "' . $titre . '".',
            'formation', $lien, $idEmp
        );

        if (!empty($chefsDir)) {
            $this->notif->envoyerMultiple(
                $chefsDir,
                'Invitation acceptée',
                $employe['Prenom_Emp'] . ' ' . $employe['Nom_Emp']
                . ' a accepté l\'invitation à la formation : "' . $titre . '".',
                'formation', $lien, $idEmp
            );
        }

        $this->log->insert([
            'Action_Log'      => 'ACCEPT_INVITATION',
            'Module_Log'      => 'Formation',
            'Description_Log' => 'Acceptation invitation formation "' . $titre
                               . '" — Employé ID : ' . $idEmp,
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => $idEmp,
        ]);

        return redirect()->to('formation/show/' . $id)
                         ->with('success', 'Invitation acceptée. Vous êtes confirmé(e) pour cette formation.');
    }

    // ══════════════════════════════════════════════════════════
    // REFUSER INVITATION — Employé uniquement
    // ══════════════════════════════════════════════════════════
    public function refuserInvitation($id)
    {
        if ($this->idPfl() != 3) {
            return redirect()->to('formation/show/' . $id)->with('error', 'Accès refusé.');
        }

        $db    = \Config\Database::connect();
        $idEmp = $this->idEmp();

        $inscription = $db->table('s_inscrire')
            ->where('id_Frm', $id)
            ->where('id_Emp', $idEmp)
            ->where('Stt_Ins', 'invite')
            ->get()->getRowArray();

        if (!$inscription) {
            return redirect()->to('formation/show/' . $id)
                             ->with('error', 'Aucune invitation en attente pour cette formation.');
        }

        $db->table('s_inscrire')
            ->where('id_Frm', $id)
            ->where('id_Emp', $idEmp)
            ->update(['Stt_Ins' => 'annule']);

        $formation = $db->table('formation')->where('id_Frm', $id)->get()->getRowArray();
        $employe   = (new EmployeModel())->find($idEmp);
        $lien      = base_url('formation/show/' . $id);
        $titre     = $formation['Titre_Frm'];
        $chefsDir  = $this->getChefsDirIds($employe['id_Dir']);

        $this->notif->envoyerMultiple(
            $this->getRHIds(),
            'Invitation refusée',
            $employe['Prenom_Emp'] . ' ' . $employe['Nom_Emp']
            . ' a refusé l\'invitation à la formation : "' . $titre . '".',
            'formation', $lien, $idEmp
        );

        if (!empty($chefsDir)) {
            $this->notif->envoyerMultiple(
                $chefsDir,
                'Invitation refusée',
                $employe['Prenom_Emp'] . ' ' . $employe['Nom_Emp']
                . ' a refusé l\'invitation à la formation : "' . $titre . '".',
                'formation', $lien, $idEmp
            );
        }

        $this->log->insert([
            'Action_Log'      => 'REFUSE_INVITATION',
            'Module_Log'      => 'Formation',
            'Description_Log' => 'Refus invitation formation "' . $titre
                               . '" — Employé ID : ' . $idEmp,
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => $idEmp,
        ]);

        return redirect()->to('formation/show/' . $id)
                         ->with('success', 'Invitation refusée.');
    }

    // ══════════════════════════════════════════════════════════
    // S'INSCRIRE — Employé uniquement
    // Directement validé si place disponible
    // ══════════════════════════════════════════════════════════
    public function sInscrire($id)
    {
        if ($this->idPfl() != 3) {
            return redirect()->to('formation/show/' . $id)
                             ->with('error', 'Seul un employé peut s\'inscrire à une formation.');
        }

        $db        = \Config\Database::connect();
        $idEmp     = $this->idEmp();
        $formation = $db->table('formation')->where('id_Frm', $id)->get()->getRowArray();

        if (!$formation) {
            return redirect()->to('formation')->with('error', 'Formation introuvable.');
        }

        if (in_array($formation['Statut_Frm'], ['terminee', 'annulee'])) {
            return redirect()->to('formation/show/' . $id)
                             ->with('error', 'Inscription impossible : la formation est '
                                 . $formation['Statut_Frm'] . '.');
        }

        $dejaInscrit = $db->table('s_inscrire')
            ->where('id_Frm', $id)
            ->where('id_Emp', $idEmp)
            ->whereNotIn('Stt_Ins', ['annule'])
            ->get()->getRowArray();

        if ($dejaInscrit) {
            return redirect()->to('formation/show/' . $id)
                             ->with('error', 'Vous êtes déjà inscrit à cette formation.');
        }

        $nbValides = $db->table('s_inscrire')
            ->where('id_Frm', $id)
            ->where('Stt_Ins', 'valide')
            ->countAllResults();

        if ($formation['Capacite_Frm'] > 0 && $nbValides >= $formation['Capacite_Frm']) {
            return redirect()->to('formation/show/' . $id)
                             ->with('error', 'La capacité maximale est atteinte. Inscription impossible.');
        }

        $db->table('s_inscrire')->insert([
            'id_Frm'  => $id,
            'id_Emp'  => $idEmp,
            'Stt_Ins' => 'valide',
            'Dte_Ins' => date('Y-m-d'),
        ]);

        $employe  = (new EmployeModel())->find($idEmp);
        $lien     = base_url('formation/show/' . $id);
        $titre    = $formation['Titre_Frm'];
        $chefsDir = $this->getChefsDirIds($employe['id_Dir']);

        $this->notif->envoyerMultiple(
            $this->getRHIds(),
            'Nouvelle inscription formation',
            $employe['Prenom_Emp'] . ' ' . $employe['Nom_Emp']
            . ' s\'est inscrit à la formation : "' . $titre . '".',
            'formation', $lien, $idEmp
        );

        if (!empty($chefsDir)) {
            $this->notif->envoyerMultiple(
                $chefsDir,
                'Nouvelle inscription formation',
                $employe['Prenom_Emp'] . ' ' . $employe['Nom_Emp']
                . ' s\'est inscrit à la formation : "' . $titre . '".',
                'formation', $lien, $idEmp
            );
        }

        $this->log->insert([
            'Action_Log'      => 'INSCRIPTION',
            'Module_Log'      => 'Formation',
            'Description_Log' => 'Inscription formation "' . $titre
                               . '" — Employé ID : ' . $idEmp,
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => $idEmp,
        ]);

        return redirect()->to('formation/show/' . $id)
                         ->with('success', 'Inscription confirmée avec succès.');
    }

    // ══════════════════════════════════════════════════════════
    // SE DÉSINSCRIRE — Employé uniquement
    // ══════════════════════════════════════════════════════════
    public function seDesinscrire($id)
    {
        if ($this->idPfl() != 3) {
            return redirect()->to('formation/show/' . $id)->with('error', 'Accès refusé.');
        }

        $db    = \Config\Database::connect();
        $idEmp = $this->idEmp();

        $inscription = $db->table('s_inscrire')
            ->where('id_Frm', $id)
            ->where('id_Emp', $idEmp)
            ->whereIn('Stt_Ins', ['valide', 'invite'])
            ->get()->getRowArray();

        if (!$inscription) {
            return redirect()->to('formation/show/' . $id)
                             ->with('error', 'Aucune inscription active pour cette formation.');
        }

        $formation = $db->table('formation')->where('id_Frm', $id)->get()->getRowArray();

        if ($formation['Statut_Frm'] === 'terminee') {
            return redirect()->to('formation/show/' . $id)
                             ->with('error', 'Impossible de se désinscrire d\'une formation terminée.');
        }

        $db->table('s_inscrire')
            ->where('id_Frm', $id)
            ->where('id_Emp', $idEmp)
            ->update(['Stt_Ins' => 'annule']);

        $employe  = (new EmployeModel())->find($idEmp);
        $lien     = base_url('formation/show/' . $id);
        $titre    = $formation['Titre_Frm'];
        $chefsDir = $this->getChefsDirIds($employe['id_Dir']);

        $this->notif->envoyerMultiple(
            $this->getRHIds(),
            'Désinscription formation',
            $employe['Prenom_Emp'] . ' ' . $employe['Nom_Emp']
            . ' s\'est désinscrit de la formation : "' . $titre . '".',
            'formation', $lien, $idEmp
        );

        if (!empty($chefsDir)) {
            $this->notif->envoyerMultiple(
                $chefsDir,
                'Désinscription formation',
                $employe['Prenom_Emp'] . ' ' . $employe['Nom_Emp']
                . ' s\'est désinscrit de la formation : "' . $titre . '".',
                'formation', $lien, $idEmp
            );
        }

        $this->log->insert([
            'Action_Log'      => 'DESINSCRIPTION',
            'Module_Log'      => 'Formation',
            'Description_Log' => 'Désinscription formation "' . $titre
                               . '" — Employé ID : ' . $idEmp,
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => $idEmp,
        ]);

        return redirect()->to('formation/show/' . $id)
                         ->with('success', 'Désinscription effectuée.');
    }

    // ══════════════════════════════════════════════════════════
    // CONFIRMER COMPÉTENCES — Chef uniquement
    // ══════════════════════════════════════════════════════════
    public function confirmerCompetences($id)
    {
        if ($this->idPfl() != 2) {
            return redirect()->to('formation/show/' . $id)->with('error', 'Accès refusé.');
        }

        $db    = \Config\Database::connect();
        $idEmp = $this->idEmp();
        $idDir = $this->getIdDirChef();

        $formation = $db->table('formation')->where('id_Frm', $id)->get()->getRowArray();

        if (!$formation) {
            return redirect()->to('formation')->with('error', 'Formation introuvable.');
        }

        if ($formation['DateFin_Frm'] > date('Y-m-d') && $formation['Statut_Frm'] !== 'terminee') {
            return redirect()->to('formation/show/' . $id)
                             ->with('error', 'La formation n\'est pas encore terminée.');
        }

        // Marquer comme terminée si nécessaire
        if ($formation['Statut_Frm'] !== 'terminee') {
            $db->table('formation')->where('id_Frm', $id)->update(['Statut_Frm' => 'terminee']);
        }

        $idCompetence    = (int) $this->request->getPost('id_Cmp');
        $modeSelection   = $this->request->getPost('mode_selection');
        $empSelectionnes = array_map('intval', (array) ($this->request->getPost('employes_selectionnes') ?? []));

        if (!$idCompetence) {
            return redirect()->back()->with('error', 'Veuillez sélectionner une compétence.');
        }

        // Participants valides de la direction du Chef
        $tousParticipants = $db->table('s_inscrire')
            ->select('s_inscrire.id_Emp')
            ->join('employe', 'employe.id_Emp = s_inscrire.id_Emp', 'left')
            ->where('s_inscrire.id_Frm', $id)
            ->where('employe.id_Dir', $idDir)
            ->where('s_inscrire.Stt_Ins', 'valide')
            ->get()->getResultArray();

        $tousIds = array_column($tousParticipants, 'id_Emp');

        if ($modeSelection === 'nont_pas_obtenu') {
            $obtiennent     = array_diff($tousIds, $empSelectionnes);
            $nObtiennentPas = $empSelectionnes;
        } else {
            $obtiennent     = $empSelectionnes;
            $nObtiennentPas = array_diff($tousIds, $empSelectionnes);
        }

        $niveau     = $this->request->getPost('niveau') ?? 'debutant';
        $competence = $db->table('competence')
            ->where('id_Cmp', $idCompetence)
            ->get()->getRowArray();
        $lien  = base_url('formation/show/' . $id);
        $titre = $formation['Titre_Frm'];

        foreach ($obtiennent as $idEmpBenef) {
            $prevue = $db->table('obtenir')
                ->where('id_Frm', (int)$id)
                ->where('id_Cmp', $idCompetence)
                ->where('id_Emp IS NULL')
                ->get()->getRowArray();

            $existe = $db->table('obtenir')
                ->where('id_Emp', $idEmpBenef)
                ->where('id_Cmp', $idCompetence)
                ->where('id_Frm', (int)$id)
                ->get()->getRowArray();

            if ($existe) {
                $db->table('obtenir')
                    ->where('id_Emp', $idEmpBenef)
                    ->where('id_Cmp', $idCompetence)
                    ->where('id_Frm', (int)$id)
                    ->update(['Niveau_Obt' => $niveau, 'Dte_Obt' => date('Y-m-d')]);
            } elseif ($prevue) {
                $db->table('obtenir')
                    ->where('id_Obt', $prevue['id_Obt'])
                    ->update([
                        'id_Emp'     => $idEmpBenef,
                        'Niveau_Obt' => $niveau,
                        'Dte_Obt'    => date('Y-m-d'),
                    ]);
                // Recréer l'entrée prévue pour les autres
                $db->table('obtenir')->insert([
                    'id_Emp'     => null,
                    'id_Cmp'     => $idCompetence,
                    'id_Frm'     => (int)$id,
                    'Niveau_Obt' => null,
                    'Dte_Obt'    => null,
                ]);
            } else {
                $db->table('obtenir')->insert([
                    'id_Emp'     => $idEmpBenef,
                    'id_Cmp'     => $idCompetence,
                    'id_Frm'     => (int)$id,
                    'Niveau_Obt' => $niveau,
                    'Dte_Obt'    => date('Y-m-d'),
                ]);
            }

            $this->notif->envoyer(
                $idEmpBenef,
                'Compétence acquise !',
                'Félicitations ! Suite à la formation "' . $titre
                . '", vous avez obtenu la compétence : "'
                . $competence['Libelle_Cmp'] . '" (niveau : ' . $niveau . ').',
                'formation', $lien, $idEmp
            );
        }

        foreach ($nObtiennentPas as $idEmpNon) {
            $this->notif->envoyer(
                $idEmpNon,
                'Résultat formation',
                'Suite à la formation "' . $titre
                . '", la compétence "' . $competence['Libelle_Cmp']
                . '" n\'a pas été validée pour vous.',
                'formation', $lien, $idEmp
            );
        }

        $this->notif->envoyerMultiple(
            $this->getRHIds(),
            'Compétences confirmées',
            'Le Chef de Direction a confirmé les compétences suite à la formation "'
            . $titre . '" : ' . count($obtiennent) . ' employé(s) ont obtenu "'
            . $competence['Libelle_Cmp'] . '".',
            'formation', $lien, $idEmp
        );

        $this->log->insert([
            'Action_Log'      => 'CONFIRM_COMPETENCES',
            'Module_Log'      => 'Formation',
            'Description_Log' => 'Confirmation compétences formation "' . $titre
                               . '" — "' . $competence['Libelle_Cmp']
                               . '" — ' . count($obtiennent) . ' obtenu(s)',
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => $idEmp,
        ]);

        return redirect()->to('formation/show/' . $id)
                         ->with('success', count($obtiennent)
                             . ' employé(s) ont obtenu la compétence "'
                             . $competence['Libelle_Cmp'] . '".');
    }
}