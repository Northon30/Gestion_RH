<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAbsenceTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_Abs' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'DateDemande_Abs' => [
                'type' => 'DATE',
                'null' => false,
            ],
            'DateDebut_Abs' => [
                'type' => 'DATE',
                'null' => false,
            ],
            'DateFin_Abs' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'Motif_Abs' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'Rapport_Abs' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'Statut_Abs' => [
                'type'       => 'ENUM',
                'constraint' => [
                    'en_attente',
                    'approuve_chef',
                    'rejete_chef',
                    'valide_rh',
                    'rejete_rh',
                    'expire',
                ],
                'default' => 'en_attente',
                'null'    => false,
            ],

            // ── Décision Chef de Direction ─────────────────────
            'CommentaireDir_Abs' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'DateDecisionDir_Abs' => [
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
            'CommentaireRH_Abs' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'DateValidationRH_Abs' => [
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
            'id_TAbs' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
        ]);

        $this->forge->addPrimaryKey('id_Abs');
        $this->forge->addForeignKey('id_Emp',          'employe',      'id_Emp',  'CASCADE',  'CASCADE');
        $this->forge->addForeignKey('id_TAbs',         'type_absence', 'id_TAbs', 'CASCADE',  'CASCADE');
        $this->forge->addForeignKey('id_Emp_ValidDir', 'employe',      'id_Emp',  'SET NULL', 'CASCADE');
        $this->forge->addForeignKey('id_Emp_ValidRH',  'employe',      'id_Emp',  'SET NULL', 'CASCADE');
        $this->forge->createTable('absence', false, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('absence');
    }
}