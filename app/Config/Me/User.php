<?php

namespace Config\Me;

use CodeIgniter\Config\BaseConfig;
use App\Models\UserModel;

class User extends BaseConfig
{
    private $model;

    public $id;
    public $username;
    public $nama;
    public $role;

    public function __construct()
    {
        $this->model = new UserModel;

        $user = $this->data();
        if (!empty($user)) {
            $this->id       = $user->user_id;
            $this->username = $user->username;
            $this->nama     = $user->nama;
            $this->role     = $user->role;
        }
    }

    public function isLoggedIn(): bool
    {
        if ($this->data()) {
            return TRUE;
        }
        return FALSE;
    }

    private function data()
    {
        $userId = session()->get('user_id');
        if ($userId) {
            return $this->model
                ->find($userId);
        }
        return NULL;
    }

    public function set(int $user_id)
    {
        session()->set('user_id', $user_id);
    }

    public function unset()
    {
        if ($this->isLoggedIn()) {
            session()->destroy();
        }
    }
}
