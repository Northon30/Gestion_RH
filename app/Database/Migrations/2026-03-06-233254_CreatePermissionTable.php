<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePermissionTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_Per' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'Module_Per' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => false,
            ],
            'Action_Per' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => false,
            ],
            'id_Pfl' => [
                'type'     => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null'     => false,
            ],
        ]);

        $this->forge->addPrimaryKey('id_Per');
        $this->forge->addForeignKey('id_Pfl', 'profil', 'id_Pfl', 'CASCADE', 'CASCADE');
        $this->forge->createTable('permission', false, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('permission');
    }
}