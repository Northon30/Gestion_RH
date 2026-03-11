<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TypeAbsenceSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['Libelle_TAbs' => 'Absence Justifiée'],
            ['Libelle_TAbs' => 'Absence Injustifiée'],
            ['Libelle_TAbs' => 'Permission'],
            ['Libelle_TAbs' => 'Maladie'],
        ];

        $this->db->table('type_absence')->insertBatch($data);
    }
}