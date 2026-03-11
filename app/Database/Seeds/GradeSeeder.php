<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class GradeSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['Libelle_Grd' => 'Stagiaire'],
            ['Libelle_Grd' => 'Agent'],
            ['Libelle_Grd' => 'Agent de Maîtrise'],
            ['Libelle_Grd' => 'Cadre'],
            ['Libelle_Grd' => 'Cadre Supérieur'],
            ['Libelle_Grd' => 'Directeur'],
        ];

        $this->db->table('grade')->insertBatch($data);
    }
}