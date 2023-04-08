<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Users extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_user' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
                'comment' => 'User ID. Primary key',
            ],
            'user_ref' => [
                'type' => 'CHAR',
                'constraint' => '8',
                'unique' => TRUE,
                'comment' => '8 Character user ref. Instead of sequential ID it is better to use reference to prevent bot guess.',
            ],
            'first_name' => [
                'type' => 'VARCHAR',
                'constraint' => '32',
                'comment' => 'First Name',
            ],
            'last_name' => [
                'type' => 'VARCHAR',
                'constraint' => '32',
                'comment' => 'Last Name',
            ],
            'username' => [
                'type' => 'VARCHAR',
                'constraint' => '16',
                'unique' => TRUE,
                'comment' => 'Username. This must be unique',
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => '32',
                'unique' => TRUE,
                'comment' => 'User email. This must be unique',
            ],
            'mobile' => [
                'type' => 'VARCHAR',
                'constraint' => '16',
                'comment' => 'User mobile number',
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'comment' => 'User password',
            ],
            'id_role' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'comment' => 'User role id from user_roles table',
            ],
            'status' => [
                'type' => 'TINYINT',
                'constraint' => 3,
                'default' => 1,
                'comment' => 'User status. 1: Active, 0: Disabled, -1:Deleted',
            ],
            'created_by' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'comment' => 'Id of creator',
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default null on update current_timestamp',
        ]);
        $this->forge->addKey('id_user', true);
        $this->forge->addKey('created_by');
        $this->forge->addKey('id_role');
        $this->forge->createTable('users');
    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}
