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

    // Optionnel: règles de validation
    protected $validationRules = [
        'DateDemande'      => 'required|valid_date[Y-m-d]',
        'Motif'            => 'required|string|max_length[255]',
        'Type_DFrm'        => 'required|in_list[interne,externe,libre]',
        'Statut_DFrm'      => 'required|in_list[en_attente,validée,rejetée]',
        'id_Emp'           => 'required|integer',
        'id_Frm'           => 'permit_empty|integer',
        'DateDebut_Libre'  => 'permit_empty|valid_date[Y-m-d]',
        'DateFin_Libre'    => 'permit_empty|valid_date[Y-m-d]',
        'Description_Libre'=> 'permit_empty|string|max_length[255]',
        'Lieu_Libre'       => 'permit_empty|string|max_length[100]',
        'Formateur_Libre'  => 'permit_empty|string|max_length[100]',
        'id_Emp_ValidRH'   => 'permit_empty|integer',
        'id_Emp_ValidDir'  => 'permit_empty|integer',
    ];

    protected $validationMessages = [];
}