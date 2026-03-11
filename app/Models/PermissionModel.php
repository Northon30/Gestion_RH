<?php

namespace App\Models;

use CodeIgniter\Model;

class PermissionModel extends Model
{
    protected $table            = 'permission';
    protected $primaryKey       = 'id_Per';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = [
        'Module_Per',
        'Action_Per',
        'id_Pfl'
    ];
    protected $useTimestamps    = false;
}