<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class EvenementSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'Titre_Evt'       => 'Réunion mensuelle DG',
                'Description_Evt' => 'Réunion mensuelle de la Direction Générale',
                'Date_Evt'        => '2026-03-15',
                'id_Dir'          => null, // toute l'agence
                'id_Tev'          => 2,
            ],
            [
                'Titre_Evt'       => 'Séminaire annuel ANSTAT',
                'Description_Evt' => 'Séminaire annuel ANSTAT',
                'Date_Evt'        => '2026-05-20',
                'id_Dir'          => null, // toute l'agence
                'id_Tev'          => 3,
            ],
            [
                'Titre_Evt'       => 'Fête de fin d\'année',
                'Description_Evt' => 'Fête de fin d\'année',
                'Date_Evt'        => '2026-12-20',
                'id_Dir'          => null, // toute l'agence
                'id_Tev'          => 4,
            ],
        ];

        $this->db->table('evenement')->insertBatch($data);
    }
}