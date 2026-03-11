<?php

namespace App\Models;

use CodeIgniter\Model;

class SInscrireModel extends Model
{
    protected $table            = 's_inscrire';
    protected $primaryKey       = 'id_Ins';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = [
        'Dte_Ins',
        'Stt_Ins',
        'id_Emp',
        'id_Frm'
    ];
    protected $useTimestamps    = false;
}