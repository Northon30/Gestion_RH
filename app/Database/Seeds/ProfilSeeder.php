<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProfilSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['Libelle_Pfl' => 'RH'],
            ['Libelle_Pfl' => 'Chef de Direction'],
            ['Libelle_Pfl' => 'Employé'],
        ];

        $this->db->table('profil')->insertBatch($data);
    }
}