<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Auth extends Migration
{
    public function up()
    {
        $this->forge->addField([

            'username' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
                'unique' => true
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => false,
            ],
            'role_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'null' => false,
                'default' => 3
            ],
        ]);
        $this->forge->addPrimaryKey('username');
        $this->forge->addForeignKey('role_id', 'roles', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('auth');
    }

    public function down()
    {
        $this->forge->dropTable('auth');
    }
}
