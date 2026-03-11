<?php

namespace App\Models;

use CodeIgniter\Model;

class ParticiperModel extends Model
{
    protected $table            = 'participer';
    protected $primaryKey       = 'Id_Ptr';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = [
        'Dte_Sig',
        'id_Emp',
        'id_Evt'
    ];
    protected $useTimestamps    = false;
}