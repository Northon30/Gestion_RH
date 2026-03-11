<?php

namespace App\Models;

use CodeIgniter\Model;

class ObtenirModel extends Model
{
    protected $table            = 'obtenir';
    protected $primaryKey       = 'id_Obt';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = [
        'Dte_Obt',
        'Niveau_Obt',
        'id_Emp',
        'id_Cmp'
    ];
    protected $useTimestamps    = false;
}