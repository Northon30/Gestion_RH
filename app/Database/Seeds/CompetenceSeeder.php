<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CompetenceSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['Libelle_Cmp' => 'Analyse Statistique'],
            ['Libelle_Cmp' => 'Gestion de Projet'],
            ['Libelle_Cmp' => 'Programmation PHP'],
            ['Libelle_Cmp' => 'Programmation Python'],
            ['Libelle_Cmp' => 'Base de Données'],
            ['Libelle_Cmp' => 'Comptabilité'],
            ['Libelle_Cmp' => 'Communication'],
            ['Libelle_Cmp' => 'Management'],
        ];

        $this->db->table('competence')->insertBatch($data);
    }
}