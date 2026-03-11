<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTypeCongeTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_Tcg' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'Libelle_Tcg' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => false,
            ],
        ]);

        $this->forge->addPrimaryKey('id_Tcg');
        $this->forge->createTable('type_conge', false, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('type_conge');
    }
}