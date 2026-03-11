<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCompetenceTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_Cmp' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'Libelle_Cmp' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => false,
            ],
        ]);

        $this->forge->addPrimaryKey('id_Cmp');
        $this->forge->createTable('competence', false, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('competence');
    }
}