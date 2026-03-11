<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CongeSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'Libelle_Cge'     => 'Congé annuel 2026',
                'DateDebut_Cge'   => '2026-04-01',
                'DateFin_Cge'     => '2026-04-30',
                'Statut_Cge'      => 'en_attente',
                'DateDemande_Cge' => '2026-03-01',
                'id_Emp'          => 1,
                'id_Tcg'          => 1,
            ],
            [
                'Libelle_Cge'     => 'Congé maladie',
                'DateDebut_Cge'   => '2026-03-10',
                'DateFin_Cge'     => '2026-03-15',
                'Statut_Cge'      => 'approuve',
                'DateDemande_Cge' => '2026-03-08',
                'id_Emp'          => 3,
                'id_Tcg'          => 2,
            ],
        ];

        $this->db->table('conge')->insertBatch($data);
    }
}