<?php

namespace App\Models;

use CodeIgniter\Model;

class ActivityLogModel extends Model
{
    protected $table            = 'activity_logs';
    protected $primaryKey       = 'id_Log';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = [
        'Action_Log',
        'Module_Log',
        'Description_Log',
        'IpAdresse_Log',
        'DateHeure_Log',
        'id_Emp'
    ];
    protected $useTimestamps    = false;
}