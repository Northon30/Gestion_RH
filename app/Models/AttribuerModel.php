<?php

namespace App\Models;

use CodeIgniter\Model;

class AttribuerModel extends Model
{
    protected $table            = 'attribuer';
    protected $primaryKey       = 'id_Atr';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = [
        'Dte_Aff',
        'id_Emp',
        'id_Grd'
    ];
    protected $useTimestamps    = false;
}