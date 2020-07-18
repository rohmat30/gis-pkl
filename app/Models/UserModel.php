<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table      = 'users';
    protected $primaryKey = 'user_id';

    protected $returnType     = 'object';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['username', 'nama', 'password', 'role'];

    protected $useTimestamps = true;

    protected $beforeInsert  = ['hashPassword'];
    protected $beforeUpdate  = ['hashPassword'];

    protected $validationRules = [
        'username' => 'required|alpha_numeric|min_length[3]|is_unique[users.username,user_id,{user_id}]',
        'password' => 'min_length[5]',
        'nama'     => 'required|alpha_space',
        'role'     => 'required|in_list[siswa,kajur,pembimbing,pembimbing_lapangan,staff_tu]',
    ];

    protected function hashPassword(array $data)
    {
        if (!isset($data['data']['password'])) return $data;

        $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_BCRYPT, ['cost' => 8]);

        return $data;
    }
}
