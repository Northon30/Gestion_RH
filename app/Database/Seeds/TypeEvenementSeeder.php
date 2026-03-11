<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TypeEvenementSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['Libelle_Tev' => 'Anniversaire'],
            ['Libelle_Tev' => 'Réunion'],
            ['Libelle_Tev' => 'Séminaire'],
            ['Libelle_Tev' => 'Fête d\'Entreprise'],
            ['Libelle_Tev' => 'Formation'],
        ];

        $this->db->table('type_evenement')->insertBatch($data);
    }
}