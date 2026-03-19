<?php

namespace App\Controllers;

use App\Models\NotificationModel;
use App\Models\ActivityLogModel;
use App\Models\EmployeModel;

class EvenementController extends BaseController
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
        return view("{$folder}/evenement/{$page}", $data);
    }

    // Tous les RH
    private function getRHIds(): array
    {
        $db = \Config\Database::connect();
        return array_column(
            $db->table('employe')->where('id_Pfl', 1)->get()->getResultArray(),
            'id_Emp'
        );
    }

    // Uniquement le(s) chef(s) de la direction donnée
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

    // ══════════════════════════════════════════════════════════
    // INDEX
    // ══════════════════════════════════════════════════════════
    public function index()
    {
        $db    = \Config\Database::connect();
        $idPfl = $this->idPfl();
        $idEmp = $this->idEmp();

        $evenements = $db->table('evenement')
            ->select('evenement.id_Evt, evenement.Description_Evt, evenement.Date_Evt,
                      type_evenement.id_Tev, type_evenement.Libelle_Tev,
                      COUNT(DISTINCT participer.id_Emp) AS nb_participants')
            ->join('type_evenement', 'type_evenement.id_Tev = evenement.id_Tev', 'left')
            ->join('participer',     'participer.id_Evt = evenement.id_Evt',      'left')
            ->groupBy('evenement.id_Evt')
            ->orderBy('evenement.Date_Evt', 'DESC')
            ->get()->getResultArray();

        foreach ($evenements as &$e) {
            $e['ma_participation'] = $db->table('participer')
                ->where('id_Evt', $e['id_Evt'])
                ->where('id_Emp', $idEmp)
                ->get()->getRowArray();
        }
        unset($e);

        $typesEvenement = $db->table('type_evenement')->orderBy('Libelle_Tev')->get()->getResultArray();
        $directions     = $db->table('direction')->orderBy('Nom_Dir')->get()->getResultArray();

        // Anniversaires du mois — filtrés selon le profil
        $moisActuel = date('m');
        $annivQuery = $db->table('employe')
            ->select('employe.id_Emp, employe.Nom_Emp, employe.Prenom_Emp,
                      employe.DateNaissance_Emp, employe.Email_Emp, employe.id_Dir,
                      direction.Nom_Dir, grade.Libelle_Grd,
                      MONTH(employe.DateNaissance_Emp) AS mois_naissance,
                      DAY(employe.DateNaissance_Emp)   AS jour_naissance,
                      YEAR(CURDATE()) - YEAR(employe.DateNaissance_Emp) AS age')
            ->join('direction', 'direction.id_Dir = employe.id_Dir', 'left')
            ->join('grade',     'grade.id_Grd = employe.id_Grd',     'left')
            ->where('MONTH(employe.DateNaissance_Emp)', $moisActuel)
            ->where('employe.DateNaissance_Emp IS NOT NULL');

        // Chef → uniquement sa direction
        if ($idPfl == 2) {
            $chef = (new EmployeModel())->find($idEmp);
            $annivQuery->where('employe.id_Dir', $chef['id_Dir']);
        }

        // Employé → uniquement les anniversaires de sa direction
        if ($idPfl == 3) {
            $emp = (new EmployeModel())->find($idEmp);
            $annivQuery->where('employe.id_Dir', $emp['id_Dir']);
        }

        $anniversaires = $annivQuery->orderBy('DAY(employe.DateNaissance_Emp)')->get()->getResultArray();

        $aujourdhui = date('d');
        foreach ($anniversaires as &$a) {
            $a['est_aujourd_hui'] = ($a['jour_naissance'] == $aujourdhui);
        }
        unset($a);

        $this->envoyerNotifsAnniversaire($db, $anniversaires);

        $totalEvenements   = count($evenements);
        $evtAVenir         = count(array_filter($evenements, fn($e) => $e['Date_Evt'] >= date('Y-m-d')));
        $evtPasses         = $totalEvenements - $evtAVenir;
        $totalAnniv        = count($anniversaires);
        $annivAujourdhui   = count(array_filter($anniversaires, fn($a) => $a['est_aujourd_hui']));
        $totalParticipants = $db->table('participer')->countAllResults();

        return $this->profileView('index', [
            'title'             => 'Événements & Anniversaires',
            'evenements'        => $evenements,
            'typesEvenement'    => $typesEvenement,
            'directions'        => $directions,
            'anniversaires'     => $anniversaires,
            'totalEvenements'   => $totalEvenements,
            'totalParticipants' => $totalParticipants,
            'evtAVenir'         => $evtAVenir,
            'evtPasses'         => $evtPasses,
            'totalAnniv'        => $totalAnniv,
            'annivAujourdhui'   => $annivAujourdhui,
            'moisActuel'        => date('F', mktime(0, 0, 0, $moisActuel, 1)),
            'idPfl'             => $idPfl,
            'idEmp'             => $idEmp,
        ]);
    }

    // ── Notifs anniversaire ───────────────────────────────────
    private function envoyerNotifsAnniversaire($db, array $anniversaires): void
    {
        $aujourd_hui = date('Y-m-d');

        foreach ($anniversaires as $a) {
            if (!$a['est_aujourd_hui']) continue;

            $dejaEnvoyee = $db->table('notification')
                ->where('id_Emp_Dest', $a['id_Emp'])
                ->where('Type_Notif', 'anniversaire')
                ->where('DATE(DateHeure_Notif)', $aujourd_hui)
                ->countAllResults();

            if ($dejaEnvoyee > 0) continue;

            // Notifier l'employé concerné
            $this->notif->envoyer(
                $a['id_Emp'],
                'Joyeux anniversaire ! 🎂',
                'Toute l\'équipe ANSTAT vous souhaite un joyeux anniversaire.',
                'anniversaire', base_url('profil'), null
            );

            // Notifier tous les RH
            $rhs = $db->table('employe')->where('id_Pfl', 1)->get()->getResultArray();
            foreach ($rhs as $rh) {
                if ($rh['id_Emp'] == $a['id_Emp']) continue;
                $this->notif->envoyer(
                    $rh['id_Emp'],
                    'Anniversaire aujourd\'hui',
                    $a['Prenom_Emp'] . ' ' . $a['Nom_Emp'] . ' fête son anniversaire aujourd\'hui.',
                    'anniversaire', base_url('evenement'), null
                );
            }

            // Notifier uniquement le chef de la direction de l'employé
            $chefsDir = $this->getChefsDirIds((int)$a['id_Dir']);
            foreach ($chefsDir as $idChef) {
                if ($idChef == $a['id_Emp']) continue;
                $this->notif->envoyer(
                    $idChef,
                    'Anniversaire aujourd\'hui',
                    $a['Prenom_Emp'] . ' ' . $a['Nom_Emp']
                    . ' de votre direction fête son anniversaire aujourd\'hui.',
                    'anniversaire', base_url('evenement'), null
                );
            }
        }
    }

    // ══════════════════════════════════════════════════════════
    // SHOW
    // ══════════════════════════════════════════════════════════
    public function show($id)
    {
        $db    = \Config\Database::connect();
        $idPfl = $this->idPfl();
        $idEmp = $this->idEmp();

        $evenement = $db->table('evenement')
            ->select('evenement.*, type_evenement.Libelle_Tev')
            ->join('type_evenement', 'type_evenement.id_Tev = evenement.id_Tev', 'left')
            ->where('evenement.id_Evt', $id)
            ->get()->getRowArray();

        if (!$evenement) {
            return redirect()->to('evenement')->with('error', 'Événement introuvable.');
        }

        $query = $db->table('participer')
            ->select('participer.Id_Ptr, participer.Dte_Sig,
                      employe.id_Emp, employe.Nom_Emp, employe.Prenom_Emp,
                      employe.Email_Emp, employe.Disponibilite_Emp,
                      direction.id_Dir, direction.Nom_Dir,
                      grade.Libelle_Grd')
            ->join('employe',   'employe.id_Emp = participer.id_Emp', 'left')
            ->join('direction', 'direction.id_Dir = employe.id_Dir',  'left')
            ->join('grade',     'grade.id_Grd = employe.id_Grd',      'left')
            ->where('participer.id_Evt', (int)$id);

        // Chef → uniquement sa direction
        if ($idPfl == 2) {
            $chef = (new EmployeModel())->find($idEmp);
            $query->where('employe.id_Dir', $chef['id_Dir']);
        }

        $participants = $query->orderBy('employe.Nom_Emp')->get()->getResultArray();

        $maParticipation = $db->table('participer')
            ->where('id_Evt', $id)
            ->where('id_Emp', $idEmp)
            ->get()->getRowArray();

        // Employés non inscrits disponibles pour ajout (RH et Chef)
        $employesSans = [];
        $directions   = [];

        if ($idPfl != 3) {
            $dejaIds  = array_column($participants, 'id_Emp');
            $empQuery = $db->table('employe')
                ->select('employe.id_Emp, employe.Nom_Emp, employe.Prenom_Emp, direction.Nom_Dir')
                ->join('direction', 'direction.id_Dir = employe.id_Dir', 'left')
                ->where('employe.id_Pfl', 3) // Uniquement les employés
                ->orderBy('employe.Nom_Emp');

            // Chef → uniquement sa direction
            if ($idPfl == 2) {
                $chef = (new EmployeModel())->find($idEmp);
                $empQuery->where('employe.id_Dir', $chef['id_Dir']);
            }

            if (!empty($dejaIds)) {
                $empQuery->whereNotIn('employe.id_Emp', $dejaIds);
            }

            $employesSans = $empQuery->get()->getResultArray();
            $directions   = $db->table('direction')->orderBy('Nom_Dir')->get()->getResultArray();
        }

        return $this->profileView('show', [
            'title'           => 'Événement : ' . $evenement['Description_Evt'],
            'evenement'       => $evenement,
            'participants'    => $participants,
            'maParticipation' => $maParticipation,
            'employesSans'    => $employesSans,
            'directions'      => $directions,
            'idPfl'           => $idPfl,
            'idEmp'           => $idEmp,
        ]);
    }

    // ══════════════════════════════════════════════════════════
    // CREATE / STORE / EDIT / UPDATE / DELETE — RH uniquement
    // ══════════════════════════════════════════════════════════
    public function create()
    {
        if ($this->idPfl() != 1) {
            return redirect()->to('evenement')->with('error', 'Accès refusé.');
        }

        $db             = \Config\Database::connect();
        $typesEvenement = $db->table('type_evenement')->orderBy('Libelle_Tev')->get()->getResultArray();

        return view('rh/evenement/create', [
            'title'          => 'Nouvel événement',
            'typesEvenement' => $typesEvenement,
            'idPfl'          => $this->idPfl(),
        ]);
    }

    public function store()
    {
        if ($this->idPfl() != 1) {
            return redirect()->to('evenement')->with('error', 'Accès refusé.');
        }

        if (!$this->validate([
            'Description_Evt' => 'required|min_length[3]|max_length[255]',
            'Date_Evt'        => 'required|valid_date[Y-m-d]',
            'id_Tev'          => 'required|integer',
        ])) {
            return redirect()->back()->withInput()
                             ->with('errors', $this->validator->getErrors());
        }

        $db = \Config\Database::connect();
        $db->table('evenement')->insert([
            'Description_Evt' => trim($this->request->getPost('Description_Evt')),
            'Date_Evt'        => $this->request->getPost('Date_Evt'),
            'id_Tev'          => (int)$this->request->getPost('id_Tev'),
        ]);

        $newId = $db->insertID();

        $this->log->insert([
            'Action_Log'      => 'CREATE',
            'Module_Log'      => 'Evenement',
            'Description_Log' => 'Création événement : ' . $this->request->getPost('Description_Evt'),
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => $this->idEmp(),
        ]);

        return redirect()->to('evenement/show/' . $newId)->with('success', 'Événement créé avec succès.');
    }

    public function edit($id)
    {
        if ($this->idPfl() != 1) {
            return redirect()->to('evenement')->with('error', 'Accès refusé.');
        }

        $db        = \Config\Database::connect();
        $evenement = $db->table('evenement')->where('id_Evt', $id)->get()->getRowArray();

        if (!$evenement) {
            return redirect()->to('evenement')->with('error', 'Événement introuvable.');
        }

        $typesEvenement = $db->table('type_evenement')->orderBy('Libelle_Tev')->get()->getResultArray();

        return view('rh/evenement/edit', [
            'title'          => 'Modifier l\'événement',
            'evenement'      => $evenement,
            'typesEvenement' => $typesEvenement,
            'idPfl'          => $this->idPfl(),
        ]);
    }

    public function update($id)
    {
        if ($this->idPfl() != 1) {
            return redirect()->to('evenement')->with('error', 'Accès refusé.');
        }

        $db        = \Config\Database::connect();
        $evenement = $db->table('evenement')->where('id_Evt', $id)->get()->getRowArray();

        if (!$evenement) {
            return redirect()->to('evenement')->with('error', 'Événement introuvable.');
        }

        if (!$this->validate([
            'Description_Evt' => 'required|min_length[3]|max_length[255]',
            'Date_Evt'        => 'required|valid_date[Y-m-d]',
            'id_Tev'          => 'required|integer',
        ])) {
            return redirect()->back()->withInput()
                             ->with('errors', $this->validator->getErrors());
        }

        $db->table('evenement')->where('id_Evt', $id)->update([
            'Description_Evt' => trim($this->request->getPost('Description_Evt')),
            'Date_Evt'        => $this->request->getPost('Date_Evt'),
            'id_Tev'          => (int)$this->request->getPost('id_Tev'),
        ]);

        $this->log->insert([
            'Action_Log'      => 'UPDATE',
            'Module_Log'      => 'Evenement',
            'Description_Log' => 'Modification événement ID : ' . $id,
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => $this->idEmp(),
        ]);

        return redirect()->to('evenement/show/' . $id)->with('success', 'Événement modifié avec succès.');
    }

    public function delete($id)
    {
        if ($this->idPfl() != 1) {
            return redirect()->to('evenement')->with('error', 'Accès refusé.');
        }

        $db        = \Config\Database::connect();
        $evenement = $db->table('evenement')->where('id_Evt', $id)->get()->getRowArray();

        if (!$evenement) {
            return redirect()->to('evenement')->with('error', 'Événement introuvable.');
        }

        $db->table('participer')->where('id_Evt', $id)->delete();
        $db->table('evenement')->where('id_Evt', $id)->delete();

        $this->log->insert([
            'Action_Log'      => 'DELETE',
            'Module_Log'      => 'Evenement',
            'Description_Log' => 'Suppression événement : ' . $evenement['Description_Evt'],
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => $this->idEmp(),
        ]);

        return redirect()->to('evenement')->with('success', 'Événement supprimé.');
    }

    // ══════════════════════════════════════════════════════════
    // GESTION PARTICIPANTS — RH et Chef
    // RH : tous les employés
    // Chef : uniquement les employés de SA direction
    // ══════════════════════════════════════════════════════════
    public function ajouterParticipant($idEvt)
    {
        $idPfl = $this->idPfl();

        // RH et Chef peuvent ajouter des participants
        if (!in_array($idPfl, [1, 2])) {
            return redirect()->to('evenement')->with('error', 'Accès refusé.');
        }

        $db        = \Config\Database::connect();
        $evenement = $db->table('evenement')->where('id_Evt', $idEvt)->get()->getRowArray();

        if (!$evenement) {
            return redirect()->to('evenement')->with('error', 'Événement introuvable.');
        }

        $idEmpCible = (int)$this->request->getPost('id_Emp');

        if (!$idEmpCible) {
            return redirect()->to('evenement/show/' . $idEvt)->with('error', 'Employé invalide.');
        }

        // Chef → vérifier que l'employé est dans sa direction
        if ($idPfl == 2) {
            $chef    = (new EmployeModel())->find($this->idEmp());
            $employe = (new EmployeModel())->find($idEmpCible);
            if ($employe['id_Dir'] != $chef['id_Dir']) {
                return redirect()->to('evenement/show/' . $idEvt)
                                 ->with('error', 'Accès refusé. Cet employé n\'est pas dans votre direction.');
            }
        }

        $existant = $db->table('participer')
            ->where('id_Emp', $idEmpCible)
            ->where('id_Evt', $idEvt)
            ->countAllResults();

        if ($existant > 0) {
            return redirect()->to('evenement/show/' . $idEvt)
                             ->with('error', 'Cet employé participe déjà à cet événement.');
        }

        $db->table('participer')->insert([
            'Dte_Sig' => date('Y-m-d'),
            'id_Emp'  => $idEmpCible,
            'id_Evt'  => (int)$idEvt,
        ]);

        // Notifier uniquement l'employé ajouté
        $this->notif->envoyer(
            $idEmpCible,
            'Participation à un événement',
            'Vous avez été inscrit à l\'événement : ' . $evenement['Description_Evt']
            . ' (' . date('d/m/Y', strtotime($evenement['Date_Evt'])) . ').',
            'evenement', base_url('evenement/show/' . $idEvt), $this->idEmp()
        );

        $this->log->insert([
            'Action_Log'      => 'AJOUTER_PARTICIPANT',
            'Module_Log'      => 'Evenement',
            'Description_Log' => 'Ajout participant ID ' . $idEmpCible . ' à l\'événement ID : ' . $idEvt,
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => $this->idEmp(),
        ]);

        return redirect()->to('evenement/show/' . $idEvt)->with('success', 'Participant ajouté avec succès.');
    }

    public function ajouterParticipants($idEvt)
    {
        $idPfl = $this->idPfl();

        // RH et Chef peuvent ajouter des participants
        if (!in_array($idPfl, [1, 2])) {
            return redirect()->to('evenement')->with('error', 'Accès refusé.');
        }

        $db        = \Config\Database::connect();
        $evenement = $db->table('evenement')->where('id_Evt', $idEvt)->get()->getRowArray();

        if (!$evenement) {
            return redirect()->to('evenement')->with('error', 'Événement introuvable.');
        }

        $ids = $this->request->getPost('ids_Emp');

        if (empty($ids) || !is_array($ids)) {
            return redirect()->to('evenement/show/' . $idEvt)->with('error', 'Aucun employé sélectionné.');
        }

        // Chef → récupérer sa direction pour vérification
        $chef = ($idPfl == 2) ? (new EmployeModel())->find($this->idEmp()) : null;

        $ajoutes = 0;
        $ignores = 0;

        foreach ($ids as $idEmpCible) {
            $idEmpCible = (int)$idEmpCible;
            if (!$idEmpCible) continue;

            // Chef → vérifier que l'employé est dans sa direction
            if ($idPfl == 2) {
                $employe = (new EmployeModel())->find($idEmpCible);
                if ($employe['id_Dir'] != $chef['id_Dir']) {
                    $ignores++;
                    continue;
                }
            }

            $existe = $db->table('participer')
                ->where('id_Emp', $idEmpCible)
                ->where('id_Evt', (int)$idEvt)
                ->countAllResults();

            if ($existe > 0) { $ignores++; continue; }

            $db->table('participer')->insert([
                'Dte_Sig' => date('Y-m-d'),
                'id_Emp'  => $idEmpCible,
                'id_Evt'  => (int)$idEvt,
            ]);

            // Notifier uniquement l'employé ajouté
            $this->notif->envoyer(
                $idEmpCible,
                'Participation à un événement',
                'Vous avez été inscrit à l\'événement : ' . $evenement['Description_Evt']
                . ' (' . date('d/m/Y', strtotime($evenement['Date_Evt'])) . ').',
                'evenement', base_url('evenement/show/' . $idEvt), $this->idEmp()
            );

            $ajoutes++;
        }

        $this->log->insert([
            'Action_Log'      => 'AJOUTER_PARTICIPANTS',
            'Module_Log'      => 'Evenement',
            'Description_Log' => $ajoutes . ' participant(s) ajouté(s) à l\'événement ID : ' . $idEvt,
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => $this->idEmp(),
        ]);

        $msg = $ajoutes . ' participant(s) ajouté(s).';
        if ($ignores > 0) $msg .= ' ' . $ignores . ' ignoré(s) (déjà inscrits ou hors direction).';

        return redirect()->to('evenement/show/' . $idEvt)->with('success', $msg);
    }

    public function retirerParticipant($idPtr)
    {
        $idPfl = $this->idPfl();

        // RH et Chef peuvent retirer des participants
        if (!in_array($idPfl, [1, 2])) {
            return redirect()->to('evenement')->with('error', 'Accès refusé.');
        }

        $db            = \Config\Database::connect();
        $participation = $db->table('participer')->where('Id_Ptr', $idPtr)->get()->getRowArray();

        if (!$participation) {
            return redirect()->to('evenement')->with('error', 'Participation introuvable.');
        }

        // Chef → vérifier que l'employé est dans sa direction
        if ($idPfl == 2) {
            $chef    = (new EmployeModel())->find($this->idEmp());
            $employe = (new EmployeModel())->find($participation['id_Emp']);
            if ($employe['id_Dir'] != $chef['id_Dir']) {
                return redirect()->to('evenement/show/' . $participation['id_Evt'])
                                 ->with('error', 'Accès refusé. Cet employé n\'est pas dans votre direction.');
            }
        }

        $idEvt = $participation['id_Evt'];
        $db->table('participer')->where('Id_Ptr', $idPtr)->delete();

        $evenement = $db->table('evenement')->where('id_Evt', $idEvt)->get()->getRowArray();

        // Notifier uniquement l'employé retiré
        $this->notif->envoyer(
            $participation['id_Emp'],
            'Retrait de participation',
            'Vous avez été retiré de l\'événement : ' . ($evenement['Description_Evt'] ?? ''),
            'evenement', base_url('evenement'), $this->idEmp()
        );

        $this->log->insert([
            'Action_Log'      => 'RETIRER_PARTICIPANT',
            'Module_Log'      => 'Evenement',
            'Description_Log' => 'Retrait participant ID ' . $participation['id_Emp'] . ' de l\'événement ID : ' . $idEvt,
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => $this->idEmp(),
        ]);

        return redirect()->to('evenement/show/' . $idEvt)->with('success', 'Participant retiré.');
    }

    public function notifierParticipants($idEvt)
    {
        if ($this->idPfl() != 1) {
            return redirect()->to('evenement')->with('error', 'Accès refusé.');
        }

        $db        = \Config\Database::connect();
        $evenement = $db->table('evenement')->where('id_Evt', $idEvt)->get()->getRowArray();

        if (!$evenement) {
            return redirect()->to('evenement')->with('error', 'Événement introuvable.');
        }

        $participants = $db->table('participer')
            ->select('participer.id_Emp')
            ->where('participer.id_Evt', $idEvt)
            ->get()->getResultArray();

        foreach ($participants as $p) {
            $this->notif->envoyer(
                $p['id_Emp'],
                'Rappel événement',
                'Rappel : l\'événement "' . $evenement['Description_Evt']
                . '" aura lieu le ' . date('d/m/Y', strtotime($evenement['Date_Evt'])) . '.',
                'evenement', base_url('evenement/show/' . $idEvt), $this->idEmp()
            );
        }

        $this->log->insert([
            'Action_Log'      => 'NOTIFIER',
            'Module_Log'      => 'Evenement',
            'Description_Log' => 'Notification rappel événement ID : ' . $idEvt
                               . ' (' . count($participants) . ' participants)',
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => $this->idEmp(),
        ]);

        return redirect()->to('evenement/show/' . $idEvt)
                         ->with('success', count($participants) . ' participant(s) notifié(s).');
    }

    // ══════════════════════════════════════════════════════════
    // PARTICIPER / SE RETIRER — Employé et Chef (soi-même)
    // ══════════════════════════════════════════════════════════
    public function participer($idEvt)
    {
        $idEmp = $this->idEmp();
        $db    = \Config\Database::connect();

        $evenement = $db->table('evenement')->where('id_Evt', $idEvt)->get()->getRowArray();

        if (!$evenement) {
            return redirect()->to('evenement')->with('error', 'Événement introuvable.');
        }

        $existant = $db->table('participer')
            ->where('id_Emp', $idEmp)
            ->where('id_Evt', $idEvt)
            ->countAllResults();

        if ($existant > 0) {
            return redirect()->to('evenement/show/' . $idEvt)
                             ->with('error', 'Vous participez déjà à cet événement.');
        }

        $db->table('participer')->insert([
            'Dte_Sig' => date('Y-m-d'),
            'id_Emp'  => $idEmp,
            'id_Evt'  => (int)$idEvt,
        ]);

        // Récupérer les infos de l'employé depuis le modèle
        $employe  = (new EmployeModel())->find($idEmp);
        $nomEmp   = $employe['Nom_Emp'] . ' ' . $employe['Prenom_Emp'];
        $lien     = base_url('evenement/show/' . $idEvt);
        $chefsDir = $this->getChefsDirIds($employe['id_Dir']);

        // Notifier le RH
        $this->notif->envoyerMultiple(
            $this->getRHIds(),
            'Nouvelle participation',
            $nomEmp . ' participe à l\'événement : ' . $evenement['Description_Evt'] . '.',
            'evenement', $lien, $idEmp
        );

        // Notifier le chef de sa direction
        if (!empty($chefsDir)) {
            $this->notif->envoyerMultiple(
                $chefsDir,
                'Nouvelle participation',
                $nomEmp . ' participe à l\'événement : ' . $evenement['Description_Evt'] . '.',
                'evenement', $lien, $idEmp
            );
        }

        $this->log->insert([
            'Action_Log'      => 'PARTICIPER',
            'Module_Log'      => 'Evenement',
            'Description_Log' => 'Participation employé ID ' . $idEmp . ' à l\'événement ID : ' . $idEvt,
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => $idEmp,
        ]);

        return redirect()->to('evenement/show/' . $idEvt)->with('success', 'Votre participation a été enregistrée.');
    }

    public function seRetirer($idEvt)
    {
        $idEmp = $this->idEmp();
        $db    = \Config\Database::connect();

        $participation = $db->table('participer')
            ->where('id_Emp', $idEmp)
            ->where('id_Evt', $idEvt)
            ->get()->getRowArray();

        if (!$participation) {
            return redirect()->to('evenement/show/' . $idEvt)
                             ->with('error', 'Vous ne participez pas à cet événement.');
        }

        $db->table('participer')->where('Id_Ptr', $participation['Id_Ptr'])->delete();

        $evenement = $db->table('evenement')->where('id_Evt', $idEvt)->get()->getRowArray();
        $employe   = (new EmployeModel())->find($idEmp);
        $nomEmp    = $employe['Nom_Emp'] . ' ' . $employe['Prenom_Emp'];
        $lien      = base_url('evenement/show/' . $idEvt);
        $chefsDir  = $this->getChefsDirIds($employe['id_Dir']);

        // Notifier le RH
        $this->notif->envoyerMultiple(
            $this->getRHIds(),
            'Retrait de participation',
            $nomEmp . ' s\'est retiré de l\'événement : ' . ($evenement['Description_Evt'] ?? '') . '.',
            'evenement', $lien, $idEmp
        );

        // Notifier le chef de sa direction
        if (!empty($chefsDir)) {
            $this->notif->envoyerMultiple(
                $chefsDir,
                'Retrait de participation',
                $nomEmp . ' s\'est retiré de l\'événement : ' . ($evenement['Description_Evt'] ?? '') . '.',
                'evenement', $lien, $idEmp
            );
        }

        $this->log->insert([
            'Action_Log'      => 'SE_RETIRER',
            'Module_Log'      => 'Evenement',
            'Description_Log' => 'Retrait employé ID ' . $idEmp . ' de l\'événement ID : ' . $idEvt,
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => $idEmp,
        ]);

        return redirect()->to('evenement/show/' . $idEvt)->with('success', 'Vous vous êtes retiré de l\'événement.');
    }
}