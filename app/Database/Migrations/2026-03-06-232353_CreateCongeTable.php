<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCongeTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_Cge' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'Libelle_Cge' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
                'null'       => false,
            ],
            'DateDebut_Cge' => [
                'type' => 'DATE',
                'null' => false,
            ],
            'DateFin_Cge' => [
                'type' => 'DATE',
                'null' => false,
            ],
            'Statut_Cge' => [
                'type'       => 'ENUM',
                'constraint' => [
                    'en_attente',
                    'approuve_chef',
                    'rejete_chef',
                    'valide_rh',
                    'rejete_rh',
                    'expire',
                ],
                'default'    => 'en_attente',
                'null'       => false,
            ],
            'DateDemande_Cge' => [
                'type' => 'DATE',
                'null' => false,
            ],

            // ── Décision Chef de Direction ─────────────────────
            'CommentaireDir_Cge' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'DateDecisionDir_Cge' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'id_Emp_ValidDir' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],

            // ── Décision RH ───────────────────────────────────
            'CommentaireRH_Cge' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'DateValidationRH_Cge' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'id_Emp_ValidRH' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],

            // ── Clés étrangères ───────────────────────────────
            'id_Emp' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
            'id_Tcg' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
        ]);

        $this->forge->addPrimaryKey('id_Cge');
        $this->forge->addForeignKey('id_Emp',         'employe',     'id_Emp', 'CASCADE',  'CASCADE');
        $this->forge->addForeignKey('id_Tcg',         'type_conge',  'id_Tcg', 'CASCADE',  'CASCADE');
        $this->forge->addForeignKey('id_Emp_ValidDir', 'employe',    'id_Emp', 'SET NULL', 'CASCADE');
        $this->forge->addForeignKey('id_Emp_ValidRH',  'employe',    'id_Emp', 'SET NULL', 'CASCADE');
        $this->forge->createTable('conge', false, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('conge');
    }
}