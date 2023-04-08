<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class Users extends Seeder
{
    public function run()
    {
        $data = [
            [
                'user_ref' => 'XWED23AB',
                'first_name' => 'Mehmet',
                'last_name' => 'Bayrak',
                'username' => 'mbayrak',
                'email' => 'test@test.cf',
                'mobile' => '07765966557',
                'password' => password_hash('123456', PASSWORD_DEFAULT),
                'id_role' => 1,
                'status' => 1,
                'created_by' => 1
            ],
        ];
        $this->db->table('users')->insert($data);

        // lets generate 1000 fake user too
        $faker = \Faker\Factory::create('en_GB');
        for ($i = 0; $i < 1000; $i++) {
            $data =
                [
                    'user_ref' => strtoupper($faker->regexify('[A-Za-z0-9]{8}')),
                    'first_name' => $faker->name,
                    'last_name' => $faker->lastName,
                    'username' => $faker->userName,
                    'email' => $faker->email,
                    'mobile' => '07'.$faker->numberBetween(111111111, 999999999),
                    'password' => password_hash($faker->password, PASSWORD_DEFAULT),
                    'id_role' => $faker->numberBetween(1, 3),
                    'status' => $faker->numberBetween(-1, 1),
                    'created_at' => date('Y-m-d, H:i:s', $faker->unixTime()),
                    'created_by' => 1
                ];
            try {
                $this->db->table('users')->insert($data);
            }
            catch (\Exception $e){
                // in case of duplicated entry skip
            }
        }
        $this->call('UserRole');
    }
}
