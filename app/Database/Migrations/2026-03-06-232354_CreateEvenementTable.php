<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateEvenementTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_Evt' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'Titre_Evt' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
                'null'       => false,
            ],
            'Description_Evt' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'Date_Evt' => [
                'type' => 'DATE',
                'null' => false,
            ],
            // null = événement pour toute l'agence, sinon spécifique à une direction
            'id_Dir' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'id_Tev' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
        ]);

        $this->forge->addPrimaryKey('id_Evt');
        $this->forge->addForeignKey('id_Tev', 'type_evenement', 'id_Tev', 'CASCADE',  'CASCADE');
        $this->forge->addForeignKey('id_Dir', 'direction',      'id_Dir', 'SET NULL', 'CASCADE');
        $this->forge->createTable('evenement', false, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('evenement');
    }
}