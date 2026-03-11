<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSInscrireTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_Ins' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'Dte_Ins' => [
                'type'    => 'DATE',
                'null'    => false,
            ],
            'Stt_Ins' => [
                'type'       => 'ENUM',
                'constraint' => ['inscrit', 'valide', 'annule'],
                'default'    => 'inscrit',
                'null'       => false,
            ],
            'id_Emp' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
            'id_Frm' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
        ]);

        $this->forge->addPrimaryKey('id_Ins');
        $this->forge->addForeignKey('id_Emp', 'employe', 'id_Emp', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_Frm', 'formation', 'id_Frm', 'CASCADE', 'CASCADE');
        $this->forge->createTable('s_inscrire', false, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('s_inscrire');
    }
}