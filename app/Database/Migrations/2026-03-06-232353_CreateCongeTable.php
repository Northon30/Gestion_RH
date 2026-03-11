<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCongeTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_Cge' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'Libelle_Cge' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
                'null'       => false,
            ],
            'DateDebut_Cge' => [
                'type' => 'DATE',
                'null' => false,
            ],
            'DateFin_Cge' => [
                'type' => 'DATE',
                'null' => false,
            ],
            'Statut_Cge' => [
                'type'       => 'ENUM',
                'constraint' => ['en_attente', 'approuve', 'rejete'],
                'default'    => 'en_attente',
                'null'       => false,
            ],
            'DateDemande_Cge' => [
                'type'    => 'DATE',
                'null'    => false,
            ],
            'id_Emp' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
            'id_Tcg' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
        ]);

        $this->forge->addPrimaryKey('id_Cge');
        $this->forge->addForeignKey('id_Emp', 'employe', 'id_Emp', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_Tcg', 'type_conge', 'id_Tcg', 'CASCADE', 'CASCADE');
        $this->forge->createTable('conge', false, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('conge');
    }
}