<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePieceJustificativeTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_PJ' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'CheminFichier_PJ' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
            'DateDepot_PJ' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'Statut_PJ' => [
                'type'       => 'ENUM',
                'constraint' => ['en_attente', 'validee', 'rejetee'],
                'default'    => 'en_attente',
                'null'       => false,
            ],
            'CommentaireRejet_PJ' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'DateValidation_PJ' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'id_Abs' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
            'id_Emp_ValidPJ' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
        ]);

        $this->forge->addPrimaryKey('id_PJ');
        $this->forge->addForeignKey('id_Abs',        'absence', 'id_Abs', 'CASCADE',  'CASCADE');
        $this->forge->addForeignKey('id_Emp_ValidPJ', 'employe', 'id_Emp', 'SET NULL', 'CASCADE');
        $this->forge->createTable('piece_justificative', false, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('piece_justificative');
    }
}