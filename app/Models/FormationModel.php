<?php

namespace App\Models;

use CodeIgniter\Model;

class FormationModel extends Model
{
    protected $table            = 'formation';
    protected $primaryKey       = 'id_Frm';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields    = [
        'Description_Frm',
        'DateDebut_Frm',
        'DateFin_Frm',
        'Lieu_Frm',
        'Formateur_Frm',
        'Capacite_Frm'
    ];

    protected $useTimestamps    = false;

    // Optionnel: règles de validation basiques
    protected $validationRules = [
        'Description_Frm' => 'required|string|max_length[255]',
        'DateDebut_Frm'   => 'required|valid_date[Y-m-d]',
        'DateFin_Frm'     => 'required|valid_date[Y-m-d]',
        'Lieu_Frm'        => 'required|string|max_length[100]',
        'Formateur_Frm'   => 'required|string|max_length[100]',
        'Capacite_Frm'    => 'required|integer|greater_than[0]'
    ];

    protected $validationMessages = [];
}