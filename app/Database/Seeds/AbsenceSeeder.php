<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AbsenceSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'DateDemande_Abs' => '2026-01-08',
                'DateDebut_Abs'   => '2026-01-10',
                'DateFin_Abs'     => '2026-01-12',
                'Motif_Abs'       => 'Absence pour raison médicale',
                'Rapport_Abs'     => 'Certificat médical fourni',
                'Statut_Abs'      => 'valide_rh',
                'id_Emp'          => 3,
                'id_TAbs'         => 4,
            ],
            [
                'DateDemande_Abs' => '2026-02-03',
                'DateDebut_Abs'   => '2026-02-05',
                'DateFin_Abs'     => '2026-02-05',
                'Motif_Abs'       => 'Permission pour affaire personnelle',
                'Rapport_Abs'     => null,
                'Statut_Abs'      => 'valide_rh',
                'id_Emp'          => 2,
                'id_TAbs'         => 3,
            ],
        ];

        $this->db->table('absence')->insertBatch($data);
    }
}