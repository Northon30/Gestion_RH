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

    private function dashboardRH()
    {
        $idEmp = (int) session()->get('id_Emp');
        $db    = \Config\Database::connect();

        $employeModel   = new EmployeModel();
        $formationModel = new FormationModel();

        $totalEmployes = $employeModel->countAll();

        $effectifParDirection = $db->table('direction d')
            ->select('d.id_Dir, d.Nom_Dir, COUNT(e.id_Emp) as nb_employes')
            ->join('employe e', 'e.id_Dir = d.id_Dir', 'left')
            ->groupBy('d.id_Dir, d.Nom_Dir')
            ->orderBy('nb_employes', 'DESC')
            ->get()->getResultArray();

        $congesEnAttente = $db->table('conge c')
            ->select('c.*, e.Nom_Emp, e.Prenom_Emp, tc.Libelle_Tcg')
            ->join('employe e', 'e.id_Emp = c.id_Emp')
            ->join('type_conge tc', 'tc.id_Tcg = c.id_Tcg')
            ->where('c.Statut_Cge', 'en_attente')
            ->orderBy('c.DateDemande_Cge', 'ASC')
            ->get()->getResultArray();

        $absencesEnCours = $db->table('absence a')
            ->select('a.*, e.Nom_Emp, e.Prenom_Emp, ta.Libelle_TAbs')
            ->join('employe e', 'e.id_Emp = a.id_Emp')
            ->join('type_absence ta', 'ta.id_TAbs = a.id_TAbs')
            ->where('a.DateDebut_Abs <=', date('Y-m-d'))
            ->where('a.DateFin_Abs >=', date('Y-m-d'))
            ->whereIn('a.Statut_Abs', ['valide_rh', 'approuve'])
            ->get()->getResultArray();

        $formationsAVenir = $formationModel
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
            'title'                   => 'Dashboard',
            'totalEmployes'           => $totalEmployes,
            'effectifParDirection'    => $effectifParDirection,
            'congesEnAttente'         => $congesEnAttente,
            'absencesEnCours'         => $absencesEnCours,
            'formationsAVenir'        => $formationsAVenir,
            'anniversaires'           => $anniversaires,
            'competencesParDirection' => $competencesParDirection,
            'participationFormations' => $participationFormations,
            'monSolde'                => $monSolde,
            'mesConges'               => $mesConges,
            'mesAbsences'             => $mesAbsences,
        ]);
    }

    private function dashboardChef()
    {
        $idEmp = (int) session()->get('id_Emp');
        $idDir = (int) session()->get('id_Dir');
        $db    = \Config\Database::connect();

        $formationModel = new FormationModel();

        $direction = $db->table('direction')
            ->where('id_Dir', $idDir)
            ->get()->getRowArray();

        $nomDirection = $direction['Nom_Dir'] ?? 'Ma Direction';

        $effectifDirection = $db->table('employe')
            ->where('id_Dir', $idDir)
            ->countAllResults();

        $congesEnAttente = $db->table('conge c')
            ->select('c.*, e.Nom_Emp, e.Prenom_Emp, tc.Libelle_Tcg')
            ->join('employe e', 'e.id_Emp = c.id_Emp')
            ->join('type_conge tc', 'tc.id_Tcg = c.id_Tcg')
            ->where('c.Statut_Cge', 'en_attente')
            ->where('e.id_Dir', $idDir)
            ->orderBy('c.DateDemande_Cge', 'ASC')
            ->get()->getResultArray();

        $absencesEnCours = $db->table('absence a')
            ->select('a.*, e.Nom_Emp, e.Prenom_Emp, ta.Libelle_TAbs')
            ->join('employe e', 'e.id_Emp = a.id_Emp')
            ->join('type_absence ta', 'ta.id_TAbs = a.id_TAbs')
            ->where('a.DateDebut_Abs <=', date('Y-m-d'))
            ->where('a.DateFin_Abs >=', date('Y-m-d'))
            ->whereIn('a.Statut_Abs', ['valide_rh', 'approuve'])
            ->where('e.id_Dir', $idDir)
            ->get()->getResultArray();

        $formationsAVenir = $formationModel
            ->where('DateDebut_Frm >', date('Y-m-d'))
            ->orderBy('DateDebut_Frm', 'ASC')
            ->findAll();

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
            'title'             => 'Dashboard',
            'nomDirection'      => $nomDirection,
            'effectifDirection' => $effectifDirection,
            'congesEnAttente'   => $congesEnAttente,
            'absencesEnCours'   => $absencesEnCours,
            'formationsAVenir'  => $formationsAVenir,
            'anniversaires'     => $anniversaires,
            'monSolde'          => $monSolde,
            'mesConges'         => $mesConges,
            'mesAbsences'       => $mesAbsences,
        ]);
    }

    private function dashboardEmploye()
    {
        $idEmp = (int) session()->get('id_Emp');
        $idDir = (int) session()->get('id_Dir');
        $db    = \Config\Database::connect();

        $formationModel = new FormationModel();

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

        $mesFormations = $db->table('s_inscrire si')
            ->select('si.*, f.Description_Frm, f.DateDebut_Frm, f.DateFin_Frm, f.Lieu_Frm, f.Formateur_Frm')
            ->join('formation f', 'f.id_Frm = si.id_Frm')
            ->where('si.id_Emp', $idEmp)
            ->orderBy('f.DateDebut_Frm', 'DESC')
            ->limit(5)
            ->get()->getResultArray();

        $mesCompetences = $db->table('obtenir o')
            ->select('o.*, c.Libelle_Cmp')
            ->join('competence c', 'c.id_Cmp = o.id_Cmp')
            ->where('o.id_Emp', $idEmp)
            ->get()->getResultArray();

        $formationsDisponibles = $formationModel
            ->where('DateDebut_Frm >', date('Y-m-d'))
            ->orderBy('DateDebut_Frm', 'ASC')
            ->limit(3)
            ->findAll();

        $anniversaires = $db->table('employe')
            ->select('id_Emp, Nom_Emp, Prenom_Emp, DateNaissance_Emp')
            ->where('MONTH(DateNaissance_Emp)', date('m'))
            ->where('id_Dir', $idDir)
            ->orderBy('DAY(DateNaissance_Emp)', 'ASC')
            ->get()->getResultArray();

        $restant = ($monSolde['NbJoursDroit_Sld'] ?? 30) - ($monSolde['NbJoursPris_Sld'] ?? 0);

        return view('employe/dashboard', [
            'title'                 => 'Dashboard',
            'monSolde'              => $monSolde,
            'restant'               => $restant,
            'mesConges'             => $mesConges,
            'mesAbsences'           => $mesAbsences,
            'mesFormations'         => $mesFormations,
            'mesCompetences'        => $mesCompetences,
            'formationsDisponibles' => $formationsDisponibles,
            'anniversaires'         => $anniversaires,
        ]);
    }
}