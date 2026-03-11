<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTypeAbsenceTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_TAbs' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'Libelle_TAbs' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => false,
            ],
        ]);

        $this->forge->addPrimaryKey('id_TAbs');
        $this->forge->createTable('type_absence', false, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('type_absence');
    }
}