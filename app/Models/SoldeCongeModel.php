<?php

namespace App\Models;

use CodeIgniter\Model;

class SoldeCongeModel extends Model
{
    protected $table            = 'solde_conge';
    protected $primaryKey       = 'id_Sld';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = [
        'Annee_Sld',
        'NbJoursDroit_Sld',
        'NbJoursPris_Sld',
        'id_Emp'
    ];
    protected $useTimestamps    = false;
}