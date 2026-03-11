<?php

namespace App\Models;

use CodeIgniter\Model;

class AbsenceModel extends Model
{
    protected $table      = 'absence';
    protected $primaryKey = 'id_Abs';

    protected $allowedFields = [
        'DateDemande_Abs',
        'DateDebut_Abs',
        'DateFin_Abs',
        'Motif_Abs',
        'Rapport_Abs',
        'Statut_Abs',
        'CommentaireRH_Abs',
        'CommentaireDir_Abs',
        'DateValidationRH_Abs',
        'DateDecisionDir_Abs',
        'id_Emp',
        'id_TAbs',
        'id_Emp_ValidRH',
        'id_Emp_ValidDir',
    ];

    protected $useTimestamps = false;
}