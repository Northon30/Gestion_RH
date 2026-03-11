<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDirectionTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_Dir' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'Nom_Dir' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => false,
            ],
        ]);

        $this->forge->addPrimaryKey('id_Dir');
        $this->forge->createTable('direction', false, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('direction');
    }
}