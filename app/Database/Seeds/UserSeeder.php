<?php

namespace App\Database\Seeds;

use App\Models\UserModel;
use CodeIgniter\CLI\CLI;
use Faker\Factory;

class UserSeeder extends \CodeIgniter\Database\Seeder
{
    public function run()
    {
        $model = new UserModel;

        $roles = ['staff_tu', 'kajur', 'pembimbing', 'pembimbing_lapangan', 'siswa'];
        $username = ['staff', 'kajur', 'pembimbing', 'pemlap', 'siswa'];

        $data = [];
        foreach ($roles as $key => $role) {
            $name = $this->getName();
            $data[$key] = [
                'nama' => $name,
                'username' => $username[$key],
                'password' => '12345',
                'role' => $role
            ];

            $model->insert($data[$key]);
            CLI::showProgress($key, (count($roles) - 1));
        }

        CLI::showProgress(false);
        CLI::table($data, ['nama', 'username', 'password', 'level']);
    }

    private function getName()
    {
        $faker = Factory::create('id_ID');
        $gender = ['male', 'female'];
        $gen = $gender[mt_rand(0, 1)];
        $lengthName = range(1, mt_rand(1, 3));
        $lastNameIndex = end($lengthName);
        $name = '';
        if (count($lengthName) > 1) {
            foreach ($lengthName as $length) {
                if ($lastNameIndex == $length) {
                    $name .=  $faker->lastName($gen);
                } else {
                    $name .=  $faker->firstName($gen) . ' ';
                }
            }
        } else {
            $name = $faker->firstName($gen);
        }
        return $name;
    }
}
