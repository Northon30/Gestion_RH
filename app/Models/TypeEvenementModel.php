<?php

namespace App\Models;

use CodeIgniter\Model;

class TypeEvenementModel extends Model
{
    protected $table            = 'type_evenement';
    protected $primaryKey       = 'id_Tev';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['Libelle_Tev'];
    protected $useTimestamps    = false;
}