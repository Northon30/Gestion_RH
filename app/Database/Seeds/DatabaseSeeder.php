<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call('DirectionSeeder');
        $this->call('GradeSeeder');
        $this->call('ProfilSeeder');
        $this->call('TypeCongeSeeder');
        $this->call('TypeAbsenceSeeder');
        $this->call('TypeEvenementSeeder');
        $this->call('CompetenceSeeder');
        $this->call('EmployeSeeder');    
        $this->call('FormationSeeder');
        $this->call('ObtenirSeeder');   
        $this->call('AbsenceSeeder');
        $this->call('CongeSeeder');
        $this->call('EvenementSeeder');
        $this->call('PermissionSeeder');
    }
}