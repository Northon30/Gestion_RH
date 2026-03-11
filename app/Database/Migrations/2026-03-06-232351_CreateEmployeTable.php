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
                'unique'     => true,
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
        $this->forge->addForeignKey('id_Dir', 'direction', 'id_Dir', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_Grd', 'grade', 'id_Grd', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_Pfl', 'profil', 'id_Pfl', 'CASCADE', 'CASCADE');
        $this->forge->createTable('employe', false, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('employe');
    }
}