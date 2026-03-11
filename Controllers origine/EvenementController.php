<?php

namespace App\Controllers;

use App\Models\NotificationModel;
use App\Models\ActivityLogModel;

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

    // ══════════════════════════════════════════════════════════
    // INDEX — liste événements + anniversaires du mois
    // ══════════════════════════════════════════════════════════
    public function index()
    {
        $db    = \Config\Database::connect();
        $idPfl = $this->idPfl();
        $idDir = session()->get('id_Dir');

        // ── Tous les événements avec stats participants ──
        $evenements = $db->table('evenement')
            ->select('evenement.id_Evt, evenement.Description_Evt, evenement.Date_Evt,
                      type_evenement.id_Tev, type_evenement.Libelle_Tev,
                      COUNT(DISTINCT participer.id_Emp) AS nb_participants')
            ->join('type_evenement', 'type_evenement.id_Tev = evenement.id_Tev', 'left')
            ->join('participer',     'participer.id_Evt = evenement.id_Evt',      'left')
            ->groupBy('evenement.id_Evt')
            ->orderBy('evenement.Date_Evt', 'DESC')
            ->get()->getResultArray();

        // ── Types d'événements pour les filtres ──
        $typesEvenement = $db->table('type_evenement')->orderBy('Libelle_Tev')->get()->getResultArray();

        // ── Directions pour les filtres ──
        $directions = $db->table('direction')->orderBy('Nom_Dir')->get()->getResultArray();

        // ── Anniversaires du mois en cours ──
        $moisActuel = date('m');
        $anniversaires = $db->table('employe')
            ->select('employe.id_Emp, employe.Nom_Emp, employe.Prenom_Emp,
                      employe.DateNaissance_Emp, employe.Email_Emp,
                      direction.Nom_Dir, grade.Libelle_Grd,
                      MONTH(employe.DateNaissance_Emp) AS mois_naissance,
                      DAY(employe.DateNaissance_Emp)   AS jour_naissance,
                      YEAR(CURDATE()) - YEAR(employe.DateNaissance_Emp) AS age')
            ->join('direction', 'direction.id_Dir = employe.id_Dir', 'left')
            ->join('grade',     'grade.id_Grd = employe.id_Grd',     'left')
            ->where('MONTH(employe.DateNaissance_Emp)', $moisActuel)
            ->where('employe.DateNaissance_Emp IS NOT NULL');

        if ($idPfl == 2) {
            $anniversaires->where('employe.id_Dir', $idDir);
        }

        $anniversaires = $anniversaires
            ->orderBy('DAY(employe.DateNaissance_Emp)')
            ->get()->getResultArray();

        // Marquer ceux dont c'est l'anniversaire aujourd'hui
        $aujourdhui = date('d');
        foreach ($anniversaires as &$a) {
            $a['est_aujourd_hui'] = ($a['jour_naissance'] == $aujourdhui);
        }
        unset($a);

        // ── Anniversaires du jour → envoyer notif si pas encore envoyée ──
        $this->envoyerNotifsAnniversaire($db, $anniversaires);

        // ── Stats globales ──
        $totalEvenements   = count($evenements);
        $totalParticipants = $db->table('participer')->countAllResults();
        $evtAVenir         = count(array_filter($evenements, fn($e) => $e['Date_Evt'] >= date('Y-m-d')));
        $evtPasses         = $totalEvenements - $evtAVenir;
        $totalAnniv        = count($anniversaires);
        $annivAujourdhui   = count(array_filter($anniversaires, fn($a) => $a['est_aujourd_hui']));

        return view('rh/evenement/index', [
            'title'           => 'Événements & Anniversaires',
            'evenements'      => $evenements,
            'typesEvenement'  => $typesEvenement,
            'directions'      => $directions,
            'anniversaires'   => $anniversaires,
            'totalEvenements' => $totalEvenements,
            'totalParticipants'=> $totalParticipants,
            'evtAVenir'       => $evtAVenir,
            'evtPasses'       => $evtPasses,
            'totalAnniv'      => $totalAnniv,
            'annivAujourdhui' => $annivAujourdhui,
            'moisActuel'      => date('F', mktime(0,0,0,$moisActuel,1)),
            'idPfl'           => $idPfl,
            'idEmp'           => $this->idEmp(),
        ]);
    }

    // ── Notifs anniversaire (déclenchées à la connexion/visite) ──
    private function envoyerNotifsAnniversaire($db, array $anniversaires): void
    {
        $aujourd_hui = date('Y-m-d');

        foreach ($anniversaires as $a) {
            if (!$a['est_aujourd_hui']) continue;

            // Vérifier si notif déjà envoyée aujourd'hui pour cet employé
            $dejaEnvoyee = $db->table('notification')
                ->where('id_Emp_Dest', $a['id_Emp'])
                ->where('Type_Notif', 'anniversaire')
                ->where('DATE(DateHeure_Notif)', $aujourd_hui)
                ->countAllResults();

            if ($dejaEnvoyee > 0) continue;

            // Notifier l'employé lui-même
            $this->notif->envoyer(
                $a['id_Emp'],
                'Joyeux anniversaire ! 🎂',
                'Toute l\'équipe ANSTAT vous souhaite un joyeux anniversaire.',
                'anniversaire',
                base_url('profil'),
                null
            );

            // Notifier les RH
            $rhs = $db->table('employe')->where('id_Pfl', 1)->get()->getResultArray();
            foreach ($rhs as $rh) {
                if ($rh['id_Emp'] == $a['id_Emp']) continue;
                $this->notif->envoyer(
                    $rh['id_Emp'],
                    'Anniversaire aujourd\'hui',
                    $a['Prenom_Emp'] . ' ' . $a['Nom_Emp'] . ' fête son anniversaire aujourd\'hui.',
                    'anniversaire',
                    base_url('evenement'),
                    null
                );
            }
        }
    }

    // ══════════════════════════════════════════════════════════
    // SHOW — détail événement + participants
    // ══════════════════════════════════════════════════════════
    public function show($id)
    {
        $db    = \Config\Database::connect();
        $idPfl = $this->idPfl();
        $idDir = session()->get('id_Dir');

        $evenement = $db->table('evenement')
            ->select('evenement.*, type_evenement.Libelle_Tev')
            ->join('type_evenement', 'type_evenement.id_Tev = evenement.id_Tev', 'left')
            ->where('evenement.id_Evt', $id)
            ->get()->getRowArray();

        if (!$evenement) {
            return redirect()->to('evenement')->with('error', 'Événement introuvable.');
        }

        // Filtres participants
        $filtreRecherche = trim($this->request->getGet('recherche') ?? '');
        $filtreIdDir     = $this->request->getGet('id_Dir');
        $filtreDateFrom  = $this->request->getGet('date_from');
        $filtreDateTo    = $this->request->getGet('date_to');

        $query = $db->table('participer')
            ->select('participer.Id_Ptr, participer.Dte_Sig,
                      employe.id_Emp, employe.Nom_Emp, employe.Prenom_Emp,
                      employe.Email_Emp, employe.Disponibilite_Emp,
                      direction.id_Dir, direction.Nom_Dir,
                      grade.Libelle_Grd')
            ->join('employe',   'employe.id_Emp = participer.id_Emp',   'left')
            ->join('direction', 'direction.id_Dir = employe.id_Dir',    'left')
            ->join('grade',     'grade.id_Grd = employe.id_Grd',        'left')
            ->where('participer.id_Evt', (int)$id);

        if ($filtreRecherche) {
            $query->groupStart()
                  ->like('employe.Nom_Emp',     $filtreRecherche)
                  ->orLike('employe.Prenom_Emp', $filtreRecherche)
                  ->groupEnd();
        }

        if ($filtreIdDir)   $query->where('employe.id_Dir', (int)$filtreIdDir);
        if ($filtreDateFrom) $query->where('participer.Dte_Sig >=', $filtreDateFrom);
        if ($filtreDateTo)   $query->where('participer.Dte_Sig <=', $filtreDateTo);

        if ($idPfl == 2) {
            $query->where('employe.id_Dir', $idDir);
        }

        $participants = $query->orderBy('employe.Nom_Emp')->get()->getResultArray();

        // Employés non encore inscrits (pour formulaire d'ajout)
        $dejaIds  = array_column($participants, 'id_Emp');
        $empQuery = $db->table('employe')
            ->select('employe.id_Emp, employe.Nom_Emp, employe.Prenom_Emp, direction.Nom_Dir')
            ->join('direction', 'direction.id_Dir = employe.id_Dir', 'left')
            ->orderBy('employe.Nom_Emp');

        if ($idPfl == 2) {
            $empQuery->where('employe.id_Dir', $idDir);
        }

        if (!empty($dejaIds)) {
            $empQuery->whereNotIn('employe.id_Emp', $dejaIds);
        }

        $employesSans = $empQuery->get()->getResultArray();
        $directions   = $db->table('direction')->orderBy('Nom_Dir')->get()->getResultArray();

        return view('rh/evenement/show', [
            'title'           => 'Événement : ' . $evenement['Description_Evt'],
            'evenement'       => $evenement,
            'participants'    => $participants,
            'employesSans'    => $employesSans,
            'directions'      => $directions,
            'filtreRecherche' => $filtreRecherche,
            'filtreIdDir'     => $filtreIdDir,
            'filtreDateFrom'  => $filtreDateFrom,
            'filtreDateTo'    => $filtreDateTo,
            'idPfl'           => $idPfl,
            'idEmp'           => $this->idEmp(),
        ]);
    }

    // ══════════════════════════════════════════════════════════
    // CREATE
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

    // ══════════════════════════════════════════════════════════
    // STORE
    // ══════════════════════════════════════════════════════════
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

        return redirect()->to('evenement/show/' . $newId)
                         ->with('success', 'Événement créé avec succès.');
    }

    // ══════════════════════════════════════════════════════════
    // EDIT
    // ══════════════════════════════════════════════════════════
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

    // ══════════════════════════════════════════════════════════
    // UPDATE
    // ══════════════════════════════════════════════════════════
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

        return redirect()->to('evenement/show/' . $id)
                         ->with('success', 'Événement modifié avec succès.');
    }

    // ══════════════════════════════════════════════════════════
    // DELETE
    // ══════════════════════════════════════════════════════════
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

        // Supprimer les participations liées
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
    // AJOUTER UN PARTICIPANT
    // ══════════════════════════════════════════════════════════
    public function ajouterParticipant($idEvt)
    {
        if ($this->idPfl() != 1) {
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

        // Vérifier doublon
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

        // Notifier l'employé
        $this->notif->envoyer(
            $idEmpCible,
            'Participation à un événement',
            'Vous avez été inscrit à l\'événement : ' . $evenement['Description_Evt']
            . ' (' . date('d/m/Y', strtotime($evenement['Date_Evt'])) . ').',
            'evenement',
            base_url('evenement/show/' . $idEvt),
            $this->idEmp()
        );

        $this->log->insert([
            'Action_Log'      => 'AJOUTER_PARTICIPANT',
            'Module_Log'      => 'Evenement',
            'Description_Log' => 'Ajout participant ID ' . $idEmpCible
                               . ' à l\'événement ID : ' . $idEvt,
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => $this->idEmp(),
        ]);

        return redirect()->to('evenement/show/' . $idEvt)
                         ->with('success', 'Participant ajouté avec succès.');
    }

    // ══════════════════════════════════════════════════════════
    // AJOUTER PLUSIEURS PARTICIPANTS EN UNE FOIS
    // ══════════════════════════════════════════════════════════
    public function ajouterParticipants($idEvt)
    {
        if ($this->idPfl() != 1) {
            return redirect()->to('evenement')->with('error', 'Accès refusé.');
        }

        $db        = \Config\Database::connect();
        $evenement = $db->table('evenement')->where('id_Evt', $idEvt)->get()->getRowArray();

        if (!$evenement) {
            return redirect()->to('evenement')->with('error', 'Événement introuvable.');
        }

        $ids = $this->request->getPost('ids_Emp');

        if (empty($ids) || !is_array($ids)) {
            return redirect()->to('evenement/show/' . $idEvt)
                             ->with('error', 'Aucun employé sélectionné.');
        }

        $ajoutes  = 0;
        $ignores  = 0;

        foreach ($ids as $idEmpCible) {
            $idEmpCible = (int)$idEmpCible;
            if (!$idEmpCible) continue;

            // Vérifier doublon
            $existe = $db->table('participer')
                ->where('id_Emp', $idEmpCible)
                ->where('id_Evt', (int)$idEvt)
                ->countAllResults();

            if ($existe > 0) {
                $ignores++;
                continue;
            }

            $db->table('participer')->insert([
                'Dte_Sig' => date('Y-m-d'),
                'id_Emp'  => $idEmpCible,
                'id_Evt'  => (int)$idEvt,
            ]);

            // Notifier l'employé
            $this->notif->envoyer(
                $idEmpCible,
                'Participation à un événement',
                'Vous avez été inscrit à l\'événement : ' . $evenement['Description_Evt']
                . ' (' . date('d/m/Y', strtotime($evenement['Date_Evt'])) . ').',
                'evenement',
                base_url('evenement/show/' . $idEvt),
                $this->idEmp()
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

        $msg = $ajoutes . ' participant(s) ajouté(s) avec succès.';
        if ($ignores > 0) {
            $msg .= ' ' . $ignores . ' ignoré(s) (déjà inscrits).';
        }

        return redirect()->to('evenement/show/' . $idEvt)->with('success', $msg);
    }

    // ══════════════════════════════════════════════════════════
    // RETIRER UN PARTICIPANT
    // ══════════════════════════════════════════════════════════
    public function retirerParticipant($idPtr)
    {
        if ($this->idPfl() != 1) {
            return redirect()->to('evenement')->with('error', 'Accès refusé.');
        }

        $db          = \Config\Database::connect();
        $participation = $db->table('participer')->where('Id_Ptr', $idPtr)->get()->getRowArray();

        if (!$participation) {
            return redirect()->to('evenement')->with('error', 'Participation introuvable.');
        }

        $idEvt = $participation['id_Evt'];
        $db->table('participer')->where('Id_Ptr', $idPtr)->delete();

        $evenement = $db->table('evenement')->where('id_Evt', $idEvt)->get()->getRowArray();

        $this->notif->envoyer(
            $participation['id_Emp'],
            'Retrait de participation',
            'Vous avez été retiré de l\'événement : ' . ($evenement['Description_Evt'] ?? ''),
            'evenement',
            base_url('evenement'),
            $this->idEmp()
        );

        $this->log->insert([
            'Action_Log'      => 'RETIRER_PARTICIPANT',
            'Module_Log'      => 'Evenement',
            'Description_Log' => 'Retrait participant ID ' . $participation['id_Emp']
                               . ' de l\'événement ID : ' . $idEvt,
            'IpAdresse_Log'   => $this->request->getIPAddress(),
            'DateHeure_Log'   => date('Y-m-d H:i:s'),
            'id_Emp'          => $this->idEmp(),
        ]);

        return redirect()->to('evenement/show/' . $idEvt)
                         ->with('success', 'Participant retiré.');
    }

    // ══════════════════════════════════════════════════════════
    // NOTIFIER TOUS LES PARTICIPANTS D'UN ÉVÉNEMENT
    // ══════════════════════════════════════════════════════════
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
                'evenement',
                base_url('evenement/show/' . $idEvt),
                $this->idEmp()
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
}