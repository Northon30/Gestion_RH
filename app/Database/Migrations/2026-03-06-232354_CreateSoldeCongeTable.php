<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSoldeCongeTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_Sld' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'Annee_Sld' => [
                'type'       => 'YEAR',
                'null'       => false,
            ],
            'NbJoursDroit_Sld' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => false,
                'default'    => 30,
            ],
            'NbJoursPris_Sld' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => false,
                'default'    => 0,
            ],
            'id_Emp' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
        ]);

        $this->forge->addPrimaryKey('id_Sld');
        $this->forge->addForeignKey('id_Emp', 'employe', 'id_Emp', 'CASCADE', 'CASCADE');
        $this->forge->createTable('solde_conge', false, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('solde_conge');
    }
}