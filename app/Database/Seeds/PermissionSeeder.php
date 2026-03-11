<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        $data = [
            // RH - accès total
            ['Module_Per' => 'Employe',    'Action_Per' => 'CREATE', 'id_Pfl' => 1],
            ['Module_Per' => 'Employe',    'Action_Per' => 'READ',   'id_Pfl' => 1],
            ['Module_Per' => 'Employe',    'Action_Per' => 'UPDATE', 'id_Pfl' => 1],
            ['Module_Per' => 'Employe',    'Action_Per' => 'DELETE', 'id_Pfl' => 1],
            ['Module_Per' => 'Conge',      'Action_Per' => 'READ',   'id_Pfl' => 1],
            ['Module_Per' => 'Conge',      'Action_Per' => 'UPDATE', 'id_Pfl' => 1],
            ['Module_Per' => 'Conge',      'Action_Per' => 'DELETE', 'id_Pfl' => 1],
            ['Module_Per' => 'Absence',    'Action_Per' => 'READ',   'id_Pfl' => 1],
            ['Module_Per' => 'Absence',    'Action_Per' => 'UPDATE', 'id_Pfl' => 1],
            ['Module_Per' => 'Formation',  'Action_Per' => 'CREATE', 'id_Pfl' => 1],
            ['Module_Per' => 'Formation',  'Action_Per' => 'READ',   'id_Pfl' => 1],
            ['Module_Per' => 'Formation',  'Action_Per' => 'UPDATE', 'id_Pfl' => 1],
            ['Module_Per' => 'Formation',  'Action_Per' => 'DELETE', 'id_Pfl' => 1],
            ['Module_Per' => 'Direction',  'Action_Per' => 'CREATE', 'id_Pfl' => 1],
            ['Module_Per' => 'Direction',  'Action_Per' => 'READ',   'id_Pfl' => 1],
            ['Module_Per' => 'Direction',  'Action_Per' => 'UPDATE', 'id_Pfl' => 1],
            ['Module_Per' => 'Direction',  'Action_Per' => 'DELETE', 'id_Pfl' => 1],

            // Chef de Direction - accès limité
            ['Module_Per' => 'Employe',    'Action_Per' => 'READ',   'id_Pfl' => 2],
            ['Module_Per' => 'Conge',      'Action_Per' => 'READ',   'id_Pfl' => 2],
            ['Module_Per' => 'Conge',      'Action_Per' => 'UPDATE', 'id_Pfl' => 2],
            ['Module_Per' => 'Absence',    'Action_Per' => 'READ',   'id_Pfl' => 2],
            ['Module_Per' => 'Formation',  'Action_Per' => 'READ',   'id_Pfl' => 2],

            // Employé - accès personnel
            ['Module_Per' => 'Conge',      'Action_Per' => 'CREATE', 'id_Pfl' => 3],
            ['Module_Per' => 'Conge',      'Action_Per' => 'READ',   'id_Pfl' => 3],
            ['Module_Per' => 'Absence',    'Action_Per' => 'READ',   'id_Pfl' => 3],
            ['Module_Per' => 'Formation',  'Action_Per' => 'READ',   'id_Pfl' => 3],
            ['Module_Per' => 'Competence', 'Action_Per' => 'READ',   'id_Pfl' => 3],
        ];

        $this->db->table('permission')->insertBatch($data);
    }
}