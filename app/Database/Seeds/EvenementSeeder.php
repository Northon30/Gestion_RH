<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class EvenementSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'Description_Evt' => 'Réunion mensuelle de la Direction Générale',
                'Date_Evt'        => '2026-03-15',
                'id_Tev'          => 2,
            ],
            [
                'Description_Evt' => 'Séminaire annuel ANSTAT',
                'Date_Evt'        => '2026-05-20',
                'id_Tev'          => 3,
            ],
            [
                'Description_Evt' => 'Fête de fin d\'année',
                'Date_Evt'        => '2026-12-20',
                'id_Tev'          => 4,
            ],
        ];

        $this->db->table('evenement')->insertBatch($data);
    }
}