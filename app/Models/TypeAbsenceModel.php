<?php

namespace App\Models;

use CodeIgniter\Model;

class TypeAbsenceModel extends Model
{
    protected $table            = 'type_absence';
    protected $primaryKey       = 'id_TAbs';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['Libelle_TAbs'];
    protected $useTimestamps    = false;
}