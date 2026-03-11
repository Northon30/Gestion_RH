<?php

namespace App\Models;

use CodeIgniter\Model;

class TypeCongeModel extends Model
{
    protected $table            = 'type_conge';
    protected $primaryKey       = 'id_Tcg';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['Libelle_Tcg'];
    protected $useTimestamps    = false;
}