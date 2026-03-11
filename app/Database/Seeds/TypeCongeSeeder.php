<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TypeCongeSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['Libelle_Tcg' => 'Congé Payé'],
            ['Libelle_Tcg' => 'Congé Maladie'],
            ['Libelle_Tcg' => 'Congé Maternité'],
            ['Libelle_Tcg' => 'Congé Paternité'],
            ['Libelle_Tcg' => 'Congé Sans Solde'],
        ];

        $this->db->table('type_conge')->insertBatch($data);
    }
}