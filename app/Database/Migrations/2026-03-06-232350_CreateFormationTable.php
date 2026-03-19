<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateFormationTable extends Migration
{
    public function up()
    {
        // ══════════════════════════════════════════════════════
        // TABLE : formation
        // ══════════════════════════════════════════════════════
        $this->forge->addField([
            'id_Frm' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'Titre_Frm' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
                'null'       => false,
            ],
            'Description_Frm' => [
                'type' => 'TEXT',
                'null' => true,
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
                'null'       => true,
            ],
            'Formateur_Frm' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'Capacite_Frm' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => false,
                'default'    => 0,
            ],
            'Statut_Frm' => [
                'type'       => 'ENUM',
                'constraint' => ['planifiee', 'en_cours', 'terminee', 'annulee'],
                'default'    => 'planifiee',
                'null'       => false,
            ],
        ]);

        $this->forge->addPrimaryKey('id_Frm');
        $this->forge->createTable('formation', false, ['ENGINE' => 'InnoDB']);

        // ══════════════════════════════════════════════════════
        // TABLE : demande_formation
        // Dépend de : formation + employe (232351)
        // FK vers employe ajoutées dans 232351_CreateEmployeTable
        // ══════════════════════════════════════════════════════
        $this->forge->addField([
            'id_DFrm' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'DateDemande' => [
                'type' => 'DATE',
                'null' => false,
            ],
            'Motif' => [
                'type' => 'TEXT',
                'null' => false,
            ],
            'Type_DFrm' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => false,
            ],
            'Statut_DFrm' => [
                'type'       => 'ENUM',
                'constraint' => ['en_attente', 'valide_rh', 'rejete_rh'],
                'default'    => 'en_attente',
                'null'       => false,
            ],
            'Description_Libre' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'DateDebut_Libre' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'DateFin_Libre' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'Lieu_Libre' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'Formateur_Libre' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'DateDecisionDir' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'DateValidRH' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'CommentaireRH' => [
                'type' => 'TEXT',
                'null' => true,
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
                'null'       => true,
            ],
            'id_Emp_ValidDir' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'id_Emp_ValidRH' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
        ]);

        $this->forge->addPrimaryKey('id_DFrm');
        $this->forge->addKey('id_Emp',      false, false, 'idx_dfrm_emp');
        $this->forge->addKey('id_Frm',      false, false, 'idx_dfrm_frm');
        $this->forge->addKey('Statut_DFrm', false, false, 'idx_dfrm_statut');
        $this->forge->createTable('demande_formation', false, ['ENGINE' => 'InnoDB']);

        // FK demande_formation → formation
        $this->db->query('ALTER TABLE `demande_formation`
            ADD CONSTRAINT `fk_dfrm_frm`
                FOREIGN KEY (`id_Frm`)
                REFERENCES `formation`(`id_Frm`)
                ON DELETE SET NULL
                ON UPDATE CASCADE
        ');

        // ══════════════════════════════════════════════════════
        // TABLE : obtenir  — association TERNAIRE
        //
        // Employé obtient une Compétence (via une Formation ou manuellement)
        //
        //   id_Frm NULL     → attribution manuelle par le Chef
        //   id_Frm renseigné → compétence obtenue à l'issue d'une formation
        //
        // FK vers employe et competence ajoutées dans 232351_CreateEmployeTable
        // car ces tables sont créées après cette migration
        // ══════════════════════════════════════════════════════
        $this->forge->addField([
            'id_Obt' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'Dte_Obt' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'Niveau_Obt' => [
                'type'       => 'ENUM',
                'constraint' => ['debutant', 'intermediaire', 'avance'],
                'null'       => false,
            ],
            'id_Emp' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
            'id_Cmp' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
            'id_Frm' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,   // NULL = attribution manuelle sans formation
            ],
        ]);

        $this->forge->addPrimaryKey('id_Obt');
        $this->forge->addKey('id_Emp', false, false, 'idx_obt_emp');
        $this->forge->addKey('id_Cmp', false, false, 'idx_obt_cmp');
        $this->forge->addKey('id_Frm', false, false, 'idx_obt_frm');
        $this->forge->createTable('obtenir', false, ['ENGINE' => 'InnoDB']);

        // FK obtenir → formation (disponible, créée au-dessus)
        $this->db->query('ALTER TABLE `obtenir`
            ADD CONSTRAINT `fk_obt_frm`
                FOREIGN KEY (`id_Frm`)
                REFERENCES `formation`(`id_Frm`)
                ON DELETE SET NULL
                ON UPDATE CASCADE
        ');

        // FK obtenir → employe et competence
        // ajoutées dans 232351_CreateEmployeTable après création de ces tables
    }

    public function down()
    {
        // Ordre inverse strict des dépendances
        $this->forge->dropTable('obtenir',           true);
        $this->forge->dropTable('demande_formation', true);
        $this->forge->dropTable('formation',         true);
    }
}