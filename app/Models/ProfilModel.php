<?php

namespace App\Models;

use CodeIgniter\Model;

class ProfilModel extends Model
{
    protected $table            = 'profil';
    protected $primaryKey       = 'id_Pfl';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['Libelle_Pfl'];
    protected $useTimestamps    = false;
}