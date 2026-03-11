<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTypeEvenementTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_Tev' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'Libelle_Tev' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => false,
            ],
        ]);

        $this->forge->addPrimaryKey('id_Tev');
        $this->forge->createTable('type_evenement', false, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('type_evenement');
    }
}