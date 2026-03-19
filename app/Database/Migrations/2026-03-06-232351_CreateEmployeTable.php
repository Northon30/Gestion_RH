<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateEmployeTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_Emp' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'Matricule_Emp' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
            ],
            'Nom_Emp' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => false,
            ],
            'Prenom_Emp' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => false,
            ],
            'Sexe_Emp' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'null'       => false,
                'comment'    => '0=Femme, 1=Homme',
            ],
            'DateNaissance_Emp' => [
                'type' => 'DATE',
                'null' => false,
            ],
            'DateEmbauche_Emp' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'Email_Emp' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
                'null'       => false,
            ],
            'Telephone_Emp' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
            ],
            'Adresse_Emp' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'Disponibilite_Emp' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'null'       => false,
                'default'    => 1,
                'comment'    => '0=Indisponible, 1=Disponible',
            ],
            'Password_Emp' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
            'RememberToken_Emp' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'id_Dir' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
            'id_Grd' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
            'id_Pfl' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
        ]);

        $this->forge->addPrimaryKey('id_Emp');
        $this->forge->addUniqueKey('Email_Emp');
        $this->forge->addUniqueKey('Matricule_Emp');
        $this->forge->addKey('id_Dir', false, false, 'employe_id_Dir_foreign');
        $this->forge->addKey('id_Grd', false, false, 'employe_id_Grd_foreign');
        $this->forge->addKey('id_Pfl', false, false, 'employe_id_Pfl_foreign');
        $this->forge->createTable('employe', false, ['ENGINE' => 'InnoDB']);

        // FK employe → direction / grade / profil
        $this->db->query('ALTER TABLE `employe`
            ADD CONSTRAINT `employe_id_Dir_foreign`
                FOREIGN KEY (`id_Dir`) REFERENCES `direction`(`id_Dir`) ON DELETE CASCADE ON UPDATE CASCADE,
            ADD CONSTRAINT `employe_id_Grd_foreign`
                FOREIGN KEY (`id_Grd`) REFERENCES `grade`(`id_Grd`)     ON DELETE CASCADE ON UPDATE CASCADE,
            ADD CONSTRAINT `employe_id_Pfl_foreign`
                FOREIGN KEY (`id_Pfl`) REFERENCES `profil`(`id_Pfl`)    ON DELETE CASCADE ON UPDATE CASCADE
        ');

        // ── FK demande_formation → employe (maintenant disponible) ──
        $this->db->query('ALTER TABLE `demande_formation`
            ADD CONSTRAINT `fk_dfrm_emp`
                FOREIGN KEY (`id_Emp`)          REFERENCES `employe`(`id_Emp`) ON DELETE CASCADE  ON UPDATE CASCADE,
            ADD CONSTRAINT `fk_dfrm_valid_dir`
                FOREIGN KEY (`id_Emp_ValidDir`) REFERENCES `employe`(`id_Emp`) ON DELETE SET NULL ON UPDATE CASCADE,
            ADD CONSTRAINT `fk_dfrm_valid_rh`
                FOREIGN KEY (`id_Emp_ValidRH`)  REFERENCES `employe`(`id_Emp`) ON DELETE SET NULL ON UPDATE CASCADE
        ');

        // ── FK obtenir → employe + competence (maintenant disponibles) ──
        $this->db->query('ALTER TABLE `obtenir`
            ADD CONSTRAINT `fk_obt_emp`
                FOREIGN KEY (`id_Emp`)
                REFERENCES `employe`(`id_Emp`)
                ON DELETE CASCADE ON UPDATE CASCADE,
            ADD CONSTRAINT `fk_obt_cmp`
                FOREIGN KEY (`id_Cmp`)
                REFERENCES `competence`(`id_Cmp`)
                ON DELETE CASCADE ON UPDATE CASCADE
        ');
    }

    public function down()
    {
        // Retirer les FK qui pointent vers employe avant de dropper
        $this->db->query('ALTER TABLE `demande_formation`
            DROP FOREIGN KEY `fk_dfrm_emp`,
            DROP FOREIGN KEY `fk_dfrm_valid_dir`,
            DROP FOREIGN KEY `fk_dfrm_valid_rh`
        ');

        $this->db->query('ALTER TABLE `obtenir`
            DROP FOREIGN KEY `fk_obt_emp`,
            DROP FOREIGN KEY `fk_obt_cmp`
        ');

        $this->forge->dropTable('employe', true);
    }
}