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
}