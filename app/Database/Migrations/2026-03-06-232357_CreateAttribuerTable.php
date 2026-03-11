<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAttribuerTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_Atr' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'Dte_Aff' => [
                'type' => 'DATE',
                'null' => false,
            ],
            'id_Emp' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
            'id_Grd' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
        ]);

        $this->forge->addPrimaryKey('id_Atr');
        $this->forge->addForeignKey('id_Emp', 'employe', 'id_Emp', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_Grd', 'grade', 'id_Grd', 'CASCADE', 'CASCADE');
        $this->forge->createTable('attribuer', false, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('attribuer');
    }
}