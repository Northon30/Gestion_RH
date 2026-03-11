<?php

namespace App\Models;

use CodeIgniter\Model;

class EmployeModel extends Model
{
    protected $table            = 'employe';
    protected $primaryKey       = 'id_Emp';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = [
        'Nom_Emp',
        'Prenom_Emp',
        'Sexe_Emp',
        'DateNaissance_Emp',
        'DateEmbauche_Emp',
        'Email_Emp',
        'Telephone_Emp',
        'Adresse_Emp',
        'Disponibilite_Emp',
        'Password_Emp',
        'RememberToken_Emp',
        'id_Dir',
        'id_Grd',
        'id_Pfl'
    ];
    protected $useTimestamps = false;

    // ✅ On retire les validationRules du Model complètement.
    // La validation est déjà gérée dans le Controller (store/update),
    // ce qui permet d'adapter les règles selon le contexte (create vs update).
    protected $validationRules    = [];
    protected $validationMessages = [];

    // Masquer le mot de passe
    protected $hidden = ['Password_Emp', 'RememberToken_Emp'];
}