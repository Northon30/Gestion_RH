<?php

namespace App\Controllers;

use App\Models\EmployeModel;
use App\Models\FormationModel;

class DashboardController extends BaseController
{
    public function index()
    {
        $idPfl = (int) session()->get('id_Pfl');

        return match ($idPfl) {
            1 => $this->dashboardRH(),
            2 => $this->dashboardChef(),
            3 => $this->dashboardEmploye(),
            default => redirect()->to('login'),
        };
    }

    // ══════════════════════════════════════════════════════════
    // DASHBOARD RH
    // ══════════════════════════════════════════════════════════
    private function dashboardRH()
    {
        $idEmp = (int) session()->get('id_Emp');
        $db    = \Config\Database::connect();

        $totalEmployes = (new EmployeModel())->countAll();

        $effectifParDirection = $db->table('direction d')
            ->select('d.id_Dir, d.Nom_Dir, COUNT(e.id_Emp) as nb_employes')
            ->join('employe e', 'e.id_Dir = d.id_Dir', 'left')
            ->groupBy('d.id_Dir, d.Nom_Dir')
            ->orderBy('nb_employes', 'DESC')
            ->get()->getResultArray();

        // Congés en attente de validation RH (déjà approuvés par le Chef)
        $congesAValider = $db->table('conge c')
            ->select('c.*, e.Nom_Emp, e.Prenom_Emp, tc.Libelle_Tcg, d.Nom_Dir')
            ->join('employe e',    'e.id_Emp = c.id_Emp')
            ->join('type_conge tc','tc.id_Tcg = c.id_Tcg')
            ->join('direction d',  'd.id_Dir = e.id_Dir', 'left')
            ->where('c.Statut_Cge', 'approuve_chef')
            ->orderBy('c.DateDemande_Cge', 'ASC')
            ->get()->getResultArray();

        // Congés en attente de validation Chef (pour info RH)
        $congesEnAttente = $db->table('conge c')
            ->select('c.*, e.Nom_Emp, e.Prenom_Emp, tc.Libelle_Tcg, d.Nom_Dir')
            ->join('employe e',    'e.id_Emp = c.id_Emp')
            ->join('type_conge tc','tc.id_Tcg = c.id_Tcg')
            ->join('direction d',  'd.id_Dir = e.id_Dir', 'left')
            ->where('c.Statut_Cge', 'en_attente')
            ->orderBy('c.DateDemande_Cge', 'ASC')
            ->get()->getResultArray();

        // Absences en attente de validation RH (déjà approuvées par le Chef)
        $absencesAValider = $db->table('absence a')
            ->select('a.*, e.Nom_Emp, e.Prenom_Emp, ta.Libelle_TAbs, d.Nom_Dir')
            ->join('employe e',      'e.id_Emp = a.id_Emp')
            ->join('type_absence ta','ta.id_TAbs = a.id_TAbs')
            ->join('direction d',    'd.id_Dir = e.id_Dir', 'left')
            ->where('a.Statut_Abs', 'approuve_chef')
            ->orderBy('a.DateDemande_Abs', 'ASC')
            ->get()->getResultArray();

        // Absences en cours (validées définitivement)
        $absencesEnCours = $db->table('absence a')
            ->select('a.*, e.Nom_Emp, e.Prenom_Emp, ta.Libelle_TAbs, d.Nom_Dir')
            ->join('employe e',      'e.id_Emp = a.id_Emp')
            ->join('type_absence ta','ta.id_TAbs = a.id_TAbs')
            ->join('direction d',    'd.id_Dir = e.id_Dir', 'left')
            ->where('a.DateDebut_Abs <=', date('Y-m-d'))
            ->where('a.DateFin_Abs >=', date('Y-m-d'))
            ->where('a.Statut_Abs', 'valide_rh')
            ->get()->getResultArray();

        $formationsAVenir = (new FormationModel())
            ->where('DateDebut_Frm >', date('Y-m-d'))
            ->orderBy('DateDebut_Frm', 'ASC')
            ->findAll();

        $anniversaires = $db->table('employe')
            ->select('id_Emp, Nom_Emp, Prenom_Emp, DateNaissance_Emp')
            ->where('MONTH(DateNaissance_Emp)', date('m'))
            ->orderBy('DAY(DateNaissance_Emp)', 'ASC')
            ->get()->getResultArray();

        $competencesParDirection = $db->table('direction d')
            ->select('d.Nom_Dir, COUNT(o.id_Obt) as nb_competences')
            ->join('employe e', 'e.id_Dir = d.id_Dir', 'left')
            ->join('obtenir o', 'o.id_Emp = e.id_Emp', 'left')
            ->groupBy('d.id_Dir, d.Nom_Dir')
            ->orderBy('d.Nom_Dir', 'ASC')
            ->get()->getResultArray();

        $participationFormations = $db->table('formation f')
            ->select('SUBSTRING(f.Description_Frm, 1, 25) as titre_court, COUNT(si.id_Ins) as nb_inscrits')
            ->join('s_inscrire si', 'si.id_Frm = f.id_Frm', 'left')
            ->groupBy('f.id_Frm, f.Description_Frm')
            ->orderBy('f.DateDebut_Frm', 'DESC')
            ->limit(6)
            ->get()->getResultArray();

        // Demandes de formation en attente de validation RH
        $demandesFormationAValider = $db->table('demande_formation df')
            ->select('df.*, e.Nom_Emp, e.Prenom_Emp, d.Nom_Dir')
            ->join('employe e',   'e.id_Emp = df.id_Emp')
            ->join('direction d', 'd.id_Dir = e.id_Dir', 'left')
            ->where('df.Statut_DFrm', 'en_attente')
            ->orderBy('df.DateDemande', 'ASC')
            ->get()->getResultArray();

        $monSolde = $db->table('solde_conge')
            ->where('id_Emp', $idEmp)
            ->where('Annee_Sld', date('Y'))
            ->get()->getRowArray();

        $mesConges = $db->table('conge c')
            ->select('c.*, tc.Libelle_Tcg')
            ->join('type_conge tc', 'tc.id_Tcg = c.id_Tcg')
            ->where('c.id_Emp', $idEmp)
            ->orderBy('c.DateDemande_Cge', 'DESC')
            ->limit(5)
            ->get()->getResultArray();

        $mesAbsences = $db->table('absence a')
            ->select('a.*, ta.Libelle_TAbs')
            ->join('type_absence ta', 'ta.id_TAbs = a.id_TAbs')
            ->where('a.id_Emp', $idEmp)
            ->orderBy('a.DateDemande_Abs', 'DESC')
            ->limit(5)
            ->get()->getResultArray();

        return view('rh/dashboard', [
            'title'                     => 'Dashboard',
            'totalEmployes'             => $totalEmployes,
            'effectifParDirection'      => $effectifParDirection,
            'congesAValider'            => $congesAValider,
            'congesEnAttente'           => $congesEnAttente,
            'absencesAValider'          => $absencesAValider,
            'absencesEnCours'           => $absencesEnCours,
            'formationsAVenir'          => $formationsAVenir,
            'anniversaires'             => $anniversaires,
            'competencesParDirection'   => $competencesParDirection,
            'participationFormations'   => $participationFormations,
            'demandesFormationAValider' => $demandesFormationAValider,
            'monSolde'                  => $monSolde,
            'mesConges'                 => $mesConges,
            'mesAbsences'               => $mesAbsences,
        ]);
    }

    // ══════════════════════════════════════════════════════════
    // DASHBOARD CHEF
    // ══════════════════════════════════════════════════════════
    private function dashboardChef()
    {
        $idEmp = (int) session()->get('id_Emp');
        $db    = \Config\Database::connect();

        // Récupérer la direction du Chef depuis le modèle
        $chef     = (new EmployeModel())->find($idEmp);
        $idDir    = $chef['id_Dir'];
        $direction = $db->table('direction')->where('id_Dir', $idDir)->get()->getRowArray();
        $nomDirection = $direction['Nom_Dir'] ?? 'Ma Direction';

        $effectifDirection = $db->table('employe')
            ->where('id_Dir', $idDir)
            ->countAllResults();

        // Congés en attente d'approbation Chef (étape 1)
        $congesEnAttente = $db->table('conge c')
            ->select('c.*, e.Nom_Emp, e.Prenom_Emp, tc.Libelle_Tcg')
            ->join('employe e',    'e.id_Emp = c.id_Emp')
            ->join('type_conge tc','tc.id_Tcg = c.id_Tcg')
            ->where('c.Statut_Cge', 'en_attente')
            ->where('e.id_Dir', $idDir)
            ->where('c.id_Emp !=', $idEmp)
            ->orderBy('c.DateDemande_Cge', 'ASC')
            ->get()->getResultArray();

        // Absences en attente d'approbation Chef (étape 1)
        $absencesEnAttente = $db->table('absence a')
            ->select('a.*, e.Nom_Emp, e.Prenom_Emp, ta.Libelle_TAbs')
            ->join('employe e',      'e.id_Emp = a.id_Emp')
            ->join('type_absence ta','ta.id_TAbs = a.id_TAbs')
            ->where('a.Statut_Abs', 'en_attente')
            ->where('e.id_Dir', $idDir)
            ->where('a.id_Emp !=', $idEmp)
            ->orderBy('a.DateDemande_Abs', 'ASC')
            ->get()->getResultArray();

        // Absences en cours (validées définitivement) dans la direction
        $absencesEnCours = $db->table('absence a')
            ->select('a.*, e.Nom_Emp, e.Prenom_Emp, ta.Libelle_TAbs')
            ->join('employe e',      'e.id_Emp = a.id_Emp')
            ->join('type_absence ta','ta.id_TAbs = a.id_TAbs')
            ->where('a.DateDebut_Abs <=', date('Y-m-d'))
            ->where('a.DateFin_Abs >=', date('Y-m-d'))
            ->where('a.Statut_Abs', 'valide_rh')
            ->where('e.id_Dir', $idDir)
            ->get()->getResultArray();

        $formationsAVenir = (new FormationModel())
            ->where('DateDebut_Frm >', date('Y-m-d'))
            ->orderBy('DateDebut_Frm', 'ASC')
            ->findAll();

        // Demandes de formation de sa direction
        $demandesFormation = $db->table('demande_formation df')
            ->select('df.*, e.Nom_Emp, e.Prenom_Emp')
            ->join('employe e', 'e.id_Emp = df.id_Emp')
            ->where('e.id_Dir', $idDir)
            ->whereIn('df.Statut_DFrm', ['en_attente', 'valide_rh'])
            ->orderBy('df.DateDemande', 'DESC')
            ->limit(5)
            ->get()->getResultArray();

        $anniversaires = $db->table('employe')
            ->select('id_Emp, Nom_Emp, Prenom_Emp, DateNaissance_Emp')
            ->where('MONTH(DateNaissance_Emp)', date('m'))
            ->where('id_Dir', $idDir)
            ->orderBy('DAY(DateNaissance_Emp)', 'ASC')
            ->get()->getResultArray();

        $monSolde = $db->table('solde_conge')
            ->where('id_Emp', $idEmp)
            ->where('Annee_Sld', date('Y'))
            ->get()->getRowArray();

        $mesConges = $db->table('conge c')
            ->select('c.*, tc.Libelle_Tcg')
            ->join('type_conge tc', 'tc.id_Tcg = c.id_Tcg')
            ->where('c.id_Emp', $idEmp)
            ->orderBy('c.DateDemande_Cge', 'DESC')
            ->limit(5)
            ->get()->getResultArray();

        $mesAbsences = $db->table('absence a')
            ->select('a.*, ta.Libelle_TAbs')
            ->join('type_absence ta', 'ta.id_TAbs = a.id_TAbs')
            ->where('a.id_Emp', $idEmp)
            ->orderBy('a.DateDemande_Abs', 'DESC')
            ->limit(5)
            ->get()->getResultArray();

        return view('chef/dashboard', [
            'title'               => 'Dashboard',
            'nomDirection'        => $nomDirection,
            'effectifDirection'   => $effectifDirection,
            'congesEnAttente'     => $congesEnAttente,
            'absencesEnAttente'   => $absencesEnAttente,
            'absencesEnCours'     => $absencesEnCours,
            'formationsAVenir'    => $formationsAVenir,
            'demandesFormation'   => $demandesFormation,
            'anniversaires'       => $anniversaires,
            'monSolde'            => $monSolde,
            'mesConges'           => $mesConges,
            'mesAbsences'         => $mesAbsences,
        ]);
    }

    // ══════════════════════════════════════════════════════════
    // DASHBOARD EMPLOYÉ
    // ══════════════════════════════════════════════════════════
    private function dashboardEmploye()
    {
        $idEmp = (int) session()->get('id_Emp');
        $db    = \Config\Database::connect();

        $emp   = (new EmployeModel())->find($idEmp);
        $idDir = $emp['id_Dir'];

        $monSolde = $db->table('solde_conge')
            ->where('id_Emp', $idEmp)
            ->where('Annee_Sld', date('Y'))
            ->get()->getRowArray();

        $mesConges = $db->table('conge c')
            ->select('c.*, tc.Libelle_Tcg')
            ->join('type_conge tc', 'tc.id_Tcg = c.id_Tcg')
            ->where('c.id_Emp', $idEmp)
            ->orderBy('c.DateDemande_Cge', 'DESC')
            ->limit(5)
            ->get()->getResultArray();

        $mesAbsences = $db->table('absence a')
            ->select('a.*, ta.Libelle_TAbs')
            ->join('type_absence ta', 'ta.id_TAbs = a.id_TAbs')
            ->where('a.id_Emp', $idEmp)
            ->orderBy('a.DateDemande_Abs', 'DESC')
            ->limit(5)
            ->get()->getResultArray();

        // Formations où l'employé est inscrit ou validé
        $mesFormations = $db->table('s_inscrire si')
            ->select('si.*, f.Description_Frm, f.DateDebut_Frm, f.DateFin_Frm, f.Lieu_Frm, f.Formateur_Frm')
            ->join('formation f', 'f.id_Frm = si.id_Frm')
            ->where('si.id_Emp', $idEmp)
            ->whereIn('si.Stt_Ins', ['inscrit', 'valide'])
            ->orderBy('f.DateDebut_Frm', 'DESC')
            ->limit(5)
            ->get()->getResultArray();

        // Invitations en attente de réponse
        $invitationsEnAttente = $db->table('s_inscrire si')
            ->select('si.*, f.Description_Frm, f.DateDebut_Frm, f.DateFin_Frm, f.Lieu_Frm')
            ->join('formation f', 'f.id_Frm = si.id_Frm')
            ->where('si.id_Emp', $idEmp)
            ->where('si.Stt_Ins', 'invite')
            ->orderBy('f.DateDebut_Frm', 'ASC')
            ->get()->getResultArray();

        $mesCompetences = $db->table('obtenir o')
            ->select('o.*, c.Libelle_Cmp')
            ->join('competence c', 'c.id_Cmp = o.id_Cmp')
            ->where('o.id_Emp', $idEmp)
            ->get()->getResultArray();

        // Formations disponibles avec places restantes
        $formationsDisponibles = $db->table('formation f')
            ->select('f.*,
                (f.Capacite_Frm - COUNT(si.id_Ins)) AS places_restantes')
            ->join('s_inscrire si',
                   'si.id_Frm = f.id_Frm AND si.Stt_Ins IN ("inscrit","valide","invite")',
                   'left')
            ->where('f.DateDebut_Frm >', date('Y-m-d'))
            ->groupBy('f.id_Frm')
            ->having('places_restantes >', 0)
            ->orderBy('f.DateDebut_Frm', 'ASC')
            ->limit(3)
            ->get()->getResultArray();

        $anniversaires = $db->table('employe')
            ->select('id_Emp, Nom_Emp, Prenom_Emp, DateNaissance_Emp')
            ->where('MONTH(DateNaissance_Emp)', date('m'))
            ->where('id_Dir', $idDir)
            ->orderBy('DAY(DateNaissance_Emp)', 'ASC')
            ->get()->getResultArray();

        $restant = ($monSolde['NbJoursDroit_Sld'] ?? 30) - ($monSolde['NbJoursPris_Sld'] ?? 0);

        return view('employe/dashboard', [
            'title'                => 'Dashboard',
            'monSolde'             => $monSolde,
            'restant'              => $restant,
            'mesConges'            => $mesConges,
            'mesAbsences'          => $mesAbsences,
            'mesFormations'        => $mesFormations,
            'invitationsEnAttente' => $invitationsEnAttente,
            'mesCompetences'       => $mesCompetences,
            'formationsDisponibles'=> $formationsDisponibles,
            'anniversaires'        => $anniversaires,
        ]);
    }
}