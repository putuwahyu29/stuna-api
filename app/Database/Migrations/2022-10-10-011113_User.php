<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class User extends Migration
{
    public function up()
    {

        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'username' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
                'unique' => true
            ],
            'fullName' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
            ],
            'nama_panggilan' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
                'unique' => true
            ],
            'alamat' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'default' => null
            ],
            'no_hp' => [
                'type' => 'VARCHAR',
                'constraint' => '15',
                'default' => null
            ],
            'foto' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'default' => null
            ],
            'nim' => [
                'type' => 'VARCHAR',
                'constraint' => '15',
                'default' => null
            ],
            'kelas_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'default' => null
            ]
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('kelas_id', 'kelas', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('username', 'auth', 'username', 'CASCADE', 'CASCADE');
        $this->forge->createTable('user');
    }


    public function down()
    {
        $this->forge->dropTable('user');
    }
}
