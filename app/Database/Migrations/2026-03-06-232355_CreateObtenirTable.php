<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateObtenirTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_Obt' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'Dte_Obt' => [
                'type' => 'DATE',
                'null' => false,
            ],
            'Niveau_Obt' => [
                'type'       => 'ENUM',
                'constraint' => ['debutant', 'intermediaire', 'avance'],
                'null'       => false,
            ],
            'id_Emp' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
            'id_Cmp' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
        ]);

        $this->forge->addPrimaryKey('id_Obt');
        $this->forge->addForeignKey('id_Emp', 'employe', 'id_Emp', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_Cmp', 'competence', 'id_Cmp', 'CASCADE', 'CASCADE');
        $this->forge->createTable('obtenir', false, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('obtenir');
    }
}