<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterCongeAddWorkflowFields extends Migration
{
    public function up()
    {
        // Modifier l'ENUM Statut_Cge pour inclure les nouveaux statuts
        $this->db->query("
            ALTER TABLE conge
            MODIFY COLUMN Statut_Cge ENUM(
                'en_attente',
                'approuve_chef',
                'rejete_chef',
                'valide_rh',
                'rejete_rh'
            ) NOT NULL DEFAULT 'en_attente'
        ");

        // Ajouter les colonnes de traçabilité workflow
        $this->forge->addColumn('conge', [
            'CommentaireDir_Cge' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'Statut_Cge',
            ],
            'CommentaireRH_Cge' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'CommentaireDir_Cge',
            ],
            'DateDecisionDir_Cge' => [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'CommentaireRH_Cge',
            ],
            'DateValidationRH_Cge' => [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'DateDecisionDir_Cge',
            ],
            'id_Emp_ValidDir' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
                'after'      => 'DateValidationRH_Cge',
            ],
            'id_Emp_ValidRH' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
                'after'      => 'id_Emp_ValidDir',
            ],
        ]);
    }

    public function down()
    {
        // Retirer les colonnes ajoutées
        $this->forge->dropColumn('conge', [
            'CommentaireDir_Cge',
            'CommentaireRH_Cge',
            'DateDecisionDir_Cge',
            'DateValidationRH_Cge',
            'id_Emp_ValidDir',
            'id_Emp_ValidRH',
        ]);

        // Remettre l'ancien ENUM
        $this->db->query("
            ALTER TABLE conge
            MODIFY COLUMN Statut_Cge ENUM('en_attente', 'approuve', 'rejete')
            NOT NULL DEFAULT 'en_attente'
        ");
    }
}