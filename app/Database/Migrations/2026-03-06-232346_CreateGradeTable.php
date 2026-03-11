<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateGradeTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_Grd' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'Libelle_Grd' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => false,
            ],
        ]);

        $this->forge->addPrimaryKey('id_Grd');
        $this->forge->createTable('grade', false, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('grade');
    }
}