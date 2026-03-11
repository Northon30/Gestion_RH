<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateFormationTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_Frm' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'Description_Frm' => [
                'type' => 'TEXT',
                'null' => false,
            ],
            'DateDebut_Frm' => [
                'type' => 'DATE',
                'null' => false,
            ],
            'DateFin_Frm' => [
                'type' => 'DATE',
                'null' => false,
            ],
            'Lieu_Frm' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
                'null'       => false,
            ],
            'Formateur_Frm' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => false,
            ],
            'Capacite_Frm' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => false,
            ],
        ]);

        $this->forge->addPrimaryKey('id_Frm');
        $this->forge->createTable('formation', false, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('formation');
    }
}