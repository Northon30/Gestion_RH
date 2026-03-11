<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DirectionSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['Nom_Dir' => 'Direction Générale'],
            ['Nom_Dir' => 'Direction des Ressources Humaines'],
            ['Nom_Dir' => 'Direction Informatique'],
            ['Nom_Dir' => 'Direction Financière'],
            ['Nom_Dir' => 'Cellule d\'Analyse Economique'],
        ];

        $this->db->table('direction')->insertBatch($data);
    }
}