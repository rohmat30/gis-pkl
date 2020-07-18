<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Pengguna extends BaseController
{
    protected $userModel;
    public function __construct()
    {
        $this->userModel = new UserModel;
    }

    //--------------------------------------------------------------------
    public function login()
    {
        if (user()->isLoggedIn()) {
            throw PageNotFoundException::forPageNotFound();
        }
        return view('pengguna\v-login');
    }

    public function cobaLogin()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $user = $this->userModel
            ->where('username', $username)
            ->first();

        if ($user) {
            if (password_verify($password, $user->password)) {

                user()->set($user->user_id);

                return redirect()->to('/');
            }
        }
        return redirect()->to('/login')
            ->withInput()
            ->with('alert', [
                'type' => 'danger',
                'mess' => 'Username atau password salah!'
            ]);
    }

    //--------------------------------------------------------------------
    public function logout()
    {
        user()->unset();
        return redirect()->to('/login');
    }
}
