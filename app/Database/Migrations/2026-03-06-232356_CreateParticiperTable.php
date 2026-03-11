<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateParticiperTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'Id_Ptr' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'Dte_Sig' => [
                'type' => 'DATE',
                'null' => false,
            ],
            'id_Emp' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
            'id_Evt' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
        ]);

        $this->forge->addPrimaryKey('Id_Ptr');
        $this->forge->addForeignKey('id_Emp', 'employe', 'id_Emp', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_Evt', 'evenement', 'id_Evt', 'CASCADE', 'CASCADE');
        $this->forge->createTable('participer', false, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('participer');
    }
}