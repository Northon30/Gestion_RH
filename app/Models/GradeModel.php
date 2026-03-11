<?php

namespace App\Models;

use CodeIgniter\Model;

class GradeModel extends Model
{
    protected $table            = 'grade';
    protected $primaryKey       = 'id_Grd';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['Libelle_Grd'];
    protected $useTimestamps    = false;
}