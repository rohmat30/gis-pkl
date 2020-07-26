<?php

namespace App\Database\Seeds;

use App\Models\UserModel;
use CodeIgniter\CLI\CLI;
use Faker\Factory;

class UserSeeder extends \CodeIgniter\Database\Seeder
{
    protected $model;
    protected $jumlahPembimbing;
    protected $jumlahPL;
    protected $jumlahSiswa;
    protected $jumlahTotal;
    public function __construct()
    {
        $this->model = new UserModel;
    }

    public function run()
    {
        $roles = ['staff_tu', 'kajur'];
        $username = ['staff', 'kajur'];

        $data = $this->model->first();
        if ($data) {
            $replacement = CLI::prompt('Data dalam tabel sudah ada, apakah ingin menghapusnya?', ['y', 'n']);
            if ($replacement == 'y') {
                $this->model->truncate();
            } else {
                return;
            }
        }
        $this->jumlahPembimbing = intval(CLI::prompt('Masukan jumlah pembimbing', '5'));
        $this->jumlahPL = intval(CLI::prompt('Masukan jumlah pembimbing lapangan', '10'));
        $this->jumlahSiswa = intval(CLI::prompt('Masukan jumlah siswa', '50'));
        $this->jumlahTotal = intval(2 + $this->jumlahPembimbing + $this->jumlahPL + $this->jumlahSiswa);

        $this->model->transStart();
        foreach ($roles as $key => $role) {
            $name = $this->getName();
            $data = [
                'nama' => $name,
                'username' => $username[$key],
                'password' => '12345',
                'role' => $role
            ];
            $this->model->insert($data);
            CLI::showProgress(++$key, $this->jumlahTotal);
        }
        $this->getPembimbing();
        $this->getPL();
        $this->getSiswa();
        if ($this->model->transStatus() === FALSE) {
            $this->model->transRollback();
            CLI::write('Tidak berhasil menambahkan user!');
        } else {
            $this->model->transCommit();
            CLI::showProgress(false);
        }
    }

    protected function getPembimbing()
    {
        foreach (range(1, $this->jumlahPembimbing) as $p) {
            $name = $this->getName();
            $data = [
                'nama' => $name,
                'username' => 'p' . str_pad($p, '2', '0', STR_PAD_LEFT),
                'password' => '12345',
                'role' => 'pembimbing'
            ];
            $this->model->insert($data);
            CLI::showProgress(2 + $p, $this->jumlahTotal);
        }
    }

    protected function getPL()
    {
        foreach (range(1, $this->jumlahPL) as $pl) {
            $name = $this->getName();
            $data = [
                'nama' => $name,
                'username' => 'pl' . str_pad($pl, '2', '0', STR_PAD_LEFT),
                'password' => '12345',
                'role' => 'pembimbing_lapangan'
            ];
            $this->model->insert($data);
            CLI::showProgress(2 + $this->jumlahPembimbing + $pl, $this->jumlahTotal);
        }
    }

    protected function getSiswa()
    {
        foreach (range(1, $this->jumlahSiswa) as $s) {
            $name = $this->getName();
            $data = [
                'nama' => $name,
                'username' => '20211' . str_pad($s, '3', '0', STR_PAD_LEFT),
                'password' => '12345',
                'role' => 'siswa'
            ];
            $this->model->insert($data);
            CLI::showProgress(2 + $this->jumlahPembimbing + $this->jumlahPL + $s, $this->jumlahTotal);
        }
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
