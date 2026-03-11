<?php

namespace App\Models;

use CodeIgniter\Model;

class PieceJustificativeModel extends Model
{
    protected $table            = 'piece_justificative';
    protected $primaryKey       = 'id_PJ';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields = [
        'CheminFichier_PJ',
        'DateDepot_PJ',
        'Statut_PJ',
        'CommentaireRejet_PJ',
        'DateValidation_PJ',
        'id_Abs',
        'id_Emp_ValidPJ',
    ];

    protected $useTimestamps = false;
}