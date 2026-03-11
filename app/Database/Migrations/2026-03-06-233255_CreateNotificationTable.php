<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateNotificationTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_Notif' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'Titre_Notif' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ],
            'Message_Notif' => [
                'type' => 'TEXT',
            ],
            'Type_Notif' => [
                'type'       => 'ENUM',
                'constraint' => ['conge', 'absence', 'formation', 'evenement', 'competence', 'info'],
                'default'    => 'info',
            ],
            'Lu_Notif' => [
                'type'    => 'TINYINT',
                'default' => 0,
            ],
            'DateHeure_Notif' => [
                'type' => 'DATETIME',
            ],
            'id_Emp_Dest' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'id_Emp_Src' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'Lien_Notif' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
        ]);

        $this->forge->addKey('id_Notif', true);
        $this->forge->addForeignKey('id_Emp_Dest', 'employe', 'id_Emp', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_Emp_Src',  'employe', 'id_Emp', 'SET NULL', 'CASCADE');
        $this->forge->createTable('notification', true, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('notification', true);
    }
}