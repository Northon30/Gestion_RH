<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class EmployeSeeder extends Seeder
{
    public function run()
    {
        $employes = [
            [
                'Matricule_Emp'     => 'ANS-2020-001',
                'Nom_Emp'           => 'KOUASSI',
                'Prenom_Emp'        => 'Jean',
                'Sexe_Emp'          => 1,
                'DateNaissance_Emp' => '1990-05-15',
                'DateEmbauche_Emp'  => '2020-01-10',
                'Email_Emp'         => 'jean.kouassi@anstat.ci',
                'Telephone_Emp'     => '0701020304',
                'Adresse_Emp'       => 'Cocody, Abidjan',
                'Disponibilite_Emp' => 1,
                'Password_Emp'      => password_hash('password123', PASSWORD_DEFAULT),
                'id_Dir'            => 1,
                'id_Grd'            => 4,
                'id_Pfl'            => 1, // RH
            ],
            [
                'Matricule_Emp'     => 'ANS-2018-001',
                'Nom_Emp'           => 'KONE',
                'Prenom_Emp'        => 'Aminata',
                'Sexe_Emp'          => 0,
                'DateNaissance_Emp' => '1985-03-22',
                'DateEmbauche_Emp'  => '2018-06-01',
                'Email_Emp'         => 'aminata.kone@anstat.ci',
                'Telephone_Emp'     => '0702030405',
                'Adresse_Emp'       => 'Plateau, Abidjan',
                'Disponibilite_Emp' => 1,
                'Password_Emp'      => password_hash('password123', PASSWORD_DEFAULT),
                'id_Dir'            => 2,
                'id_Grd'            => 5,
                'id_Pfl'            => 2, // Chef
            ],
            [
                'Matricule_Emp'     => 'ANS-2022-001',
                'Nom_Emp'           => 'DIALLO',
                'Prenom_Emp'        => 'Moussa',
                'Sexe_Emp'          => 1,
                'DateNaissance_Emp' => '1995-08-10',
                'DateEmbauche_Emp'  => '2022-03-15',
                'Email_Emp'         => 'moussa.diallo@anstat.ci',
                'Telephone_Emp'     => '0703040506',
                'Adresse_Emp'       => 'Yopougon, Abidjan',
                'Disponibilite_Emp' => 1,
                'Password_Emp'      => password_hash('password123', PASSWORD_DEFAULT),
                'id_Dir'            => 3,
                'id_Grd'            => 3,
                'id_Pfl'            => 3, // Employé
            ],
            [
                'Matricule_Emp'     => 'ANS-2021-001',
                'Nom_Emp'           => 'TRAORE',
                'Prenom_Emp'        => 'Fatou',
                'Sexe_Emp'          => 0,
                'DateNaissance_Emp' => '1992-11-30',
                'DateEmbauche_Emp'  => '2021-09-01',
                'Email_Emp'         => 'fatou.traore@anstat.ci',
                'Telephone_Emp'     => '0704050607',
                'Adresse_Emp'       => 'Marcory, Abidjan',
                'Disponibilite_Emp' => 1,
                'Password_Emp'      => password_hash('password123', PASSWORD_DEFAULT),
                'id_Dir'            => 5,
                'id_Grd'            => 4,
                'id_Pfl'            => 3, // Employé
            ],
            [
                'Matricule_Emp'     => 'ANS-2023-001',
                'Nom_Emp'           => 'YAO',
                'Prenom_Emp'        => 'Norton',
                'Sexe_Emp'          => 1,
                'DateNaissance_Emp' => '1998-07-25',
                'DateEmbauche_Emp'  => '2023-01-05',
                'Email_Emp'         => 'norton.yao@anstat.ci',
                'Telephone_Emp'     => '0705060708',
                'Adresse_Emp'       => 'Adjamé, Abidjan',
                'Disponibilite_Emp' => 1,
                'Password_Emp'      => password_hash('password123', PASSWORD_DEFAULT),
                'id_Dir'            => 5,
                'id_Grd'            => 2,
                'id_Pfl'            => 3, // Employé
            ],
        ];

        $this->db->table('employe')->insertBatch($employes);

        // Créer un solde de congés pour l'année en cours pour chaque employé
        $annee    = date('Y');
        $employes = $this->db->table('employe')->select('id_Emp')->get()->getResultArray();

        $soldes = [];
        foreach ($employes as $emp) {
            $soldes[] = [
                'Annee_Sld'        => $annee,
                'NbJoursDroit_Sld' => 30,
                'NbJoursPris_Sld'  => 0,
                'id_Emp'           => $emp['id_Emp'],
            ];
        }

        $this->db->table('solde_conge')->insertBatch($soldes);
    }
}