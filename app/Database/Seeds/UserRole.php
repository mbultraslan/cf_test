<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserRole extends Seeder
{
	public function run()
	{
		$data = [
			[
                'id_role'    			=>  1,
                'role_name'    		=>  'Developer'
            ],
            [
                'id_role'    			=>  2,
                'role_name'    		=>  'Admin'
            ],
            [
                'id_role'    			=>  3,
                'role_name'    		=>  'Customer'
            ]
		];
		$this->db->table('user_roles')->insertBatch($data);
	}
}
