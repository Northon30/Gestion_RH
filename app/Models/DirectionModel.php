<?php

namespace App\Models;

use CodeIgniter\Model;

class DirectionModel extends Model
{
    protected $table            = 'direction';
    protected $primaryKey       = 'id_Dir';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['Nom_Dir'];
    protected $useTimestamps    = false;
}