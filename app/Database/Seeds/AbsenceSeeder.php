<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AbsenceSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'DateDebut_Abs' => '2026-01-10',
                'DateFin_Abs'   => '2026-01-12',
                'Rapport_Abs'   => 'Absence pour raison médicale',
                'id_Emp'        => 3,
                'id_TAbs'       => 4,
            ],
            [
                'DateDebut_Abs' => '2026-02-05',
                'DateFin_Abs'   => '2026-02-05',
                'Rapport_Abs'   => 'Permission pour affaire personnelle',
                'id_Emp'        => 2,
                'id_TAbs'       => 3,
            ],
        ];

        $this->db->table('absence')->insertBatch($data);
    }
}