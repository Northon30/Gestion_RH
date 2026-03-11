<?php

namespace App\Models;

use CodeIgniter\Model;

class EvenementModel extends Model
{
    protected $table            = 'evenement';
    protected $primaryKey       = 'id_Evt';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = [
        'Description_Evt',
        'Date_Evt',
        'id_Tev'
    ];
    protected $useTimestamps    = false;
}