<?php

namespace App\Models;

use CodeIgniter\Model;

class DemandeFormationModel extends Model
{
    protected $table            = 'demande_formation';
    protected $primaryKey       = 'id_DFrm';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = [
        'DateDemande',
        'Motif',
        'Type_DFrm',
        'Statut_DFrm',
        'CommentaireRH',
        'CommentaireDir',
        'DateValidRH',
        'DateDecisionDir',
        'id_Emp',
        'id_Frm',
        'Description_Libre',
        'DateDebut_Libre',
        'DateFin_Libre',
        'Lieu_Libre',
        'Formateur_Libre',
        'id_Emp_ValidRH',
        'id_Emp_ValidDir',
    ];
    protected $useTimestamps = false;
}