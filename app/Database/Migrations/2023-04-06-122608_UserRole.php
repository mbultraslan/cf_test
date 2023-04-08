<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UserRole extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id_role'          => [
				'type'           => 'INT',
				'constraint'     => 11,
				'unsigned'       => true,
				'auto_increment' => true,
                'comment' => 'Role ID',
			],
			'role_name'       => [
				'type'       => 'VARCHAR',
				'constraint' => '32',
                'comment' => 'Role name',
			],
            'status' => [
                'type' => 'TINYINT',
                'constraint' => 3,
                'default' => 1,
                'comment' => 'Role status. 1: Active, 0: Disabled, -1:Deleted',
            ],

		]);
		$this->forge->addKey('id_role', true);
		$this->forge->addKey('status');
		$this->forge->createTable('user_roles');
	}

	public function down()
	{
		$this->forge->dropTable('user_roles');
	}
}
