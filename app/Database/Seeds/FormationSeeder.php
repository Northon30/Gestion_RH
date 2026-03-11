<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class FormationSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'Description_Frm' => 'Formation en Analyse Statistique',
                'DateDebut_Frm'   => '2026-02-01',
                'DateFin_Frm'     => '2026-02-05',
                'Lieu_Frm'        => 'Abidjan',
                'Formateur_Frm'   => 'Dr. Kouassi',
                'Capacite_Frm'    => 20,
            ],
            [
                'Description_Frm' => 'Formation en Gestion de Projet',
                'DateDebut_Frm'   => '2026-03-10',
                'DateFin_Frm'     => '2026-03-12',
                'Lieu_Frm'        => 'Yamoussoukro',
                'Formateur_Frm'   => 'M. Kone',
                'Capacite_Frm'    => 15,
            ],
            [
                'Description_Frm' => 'Formation en Base de Données',
                'DateDebut_Frm'   => '2026-04-01',
                'DateFin_Frm'     => '2026-04-03',
                'Lieu_Frm'        => 'Abidjan',
                'Formateur_Frm'   => 'Mme. Diallo',
                'Capacite_Frm'    => 10,
            ],
        ];

        $this->db->table('formation')->insertBatch($data);
    }
}