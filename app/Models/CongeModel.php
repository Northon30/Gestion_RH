<?php

namespace App\Models;

use CodeIgniter\Model;

class CongeModel extends Model
{
    protected $table      = 'conge';
    protected $primaryKey = 'id_Cge';

    protected $allowedFields = [
        'Libelle_Cge',
        'DateDebut_Cge',
        'DateFin_Cge',
        'Statut_Cge',
        'DateDemande_Cge',
        'DateValidationRH_Cge',
        'DateDecisionDir_Cge',
        'CommentaireRH_Cge',
        'CommentaireDir_Cge',
        'id_Emp_ValidRH',
        'id_Emp_ValidDir',
        'id_Emp',
        'id_Tcg',
    ];

    protected $useTimestamps = false;
}