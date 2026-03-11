<?php

namespace App\Models;

use CodeIgniter\Model;

class CompetenceModel extends Model
{
    protected $table            = 'competence';
    protected $primaryKey       = 'id_Cmp';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['Libelle_Cmp'];
    protected $useTimestamps    = false;
}