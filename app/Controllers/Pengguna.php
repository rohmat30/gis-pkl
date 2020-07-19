<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use Config\Services;

class Pengguna extends BaseController
{
    protected $userModel;
    protected $validation;
    public function __construct()
    {
        $this->userModel = new UserModel;
        $this->validation = Services::validation();
    }

    public function index()
    {
        site()->setTitle('Kelola pengguna')
            ->setBreadcrumb('Kelola pengguna');
        return view('pengguna\v-pengguna-index');
    }

    public function json()
    {
        return $this->userModel
            ->datatables();
    }

    //--------------------------------------------------------------------
    public function tambah()
    {
        site()->setTitle('Tambah pengguna')
            ->setBreadcrumb([
                'pengguna' => 'Kelola pengguna',
                'Tambah pengguna'
            ]);

        $data = [
            'nama'     => old('nama'),
            'username' => old('username'),
            'password' => old('password'),
            'role'     => old('role'),
            'roles'    => $this->userModel->getRoles(),
            'validation' => $this->validation
        ];
        return view('pengguna\v-pengguna-form', $data);
    }

    public function simpan()
    {
        $request = $this->request;
        $data = [
            'nama'     => esc($request->getPost('nama')),
            'username' => esc($request->getPost('username')),
            'password' => '12345',
            'role'     => esc($request->getPost('role')),
        ];
        if (!empty($request->getPost('password'))) {
            $data['password'] = esc($request->getPost('password'));
        }

        $rules = $this->userModel
            ->getValidationRules();
        $valid = $this->validation
            ->setRules($rules)
            ->run($data);

        if ($valid) {
            $this->userModel->save($data);
            return redirect()->to('/pengguna')
                ->with('alert', [
                    'type' => 'success',
                    'mess' => '<i class="fa fa-check"></i> Berhasil menambahkan pengguna'
                ]);
        }
        return redirect()->back()
            ->withInput();
    }

    //--------------------------------------------------------------------
    public function edit(int $id)
    {
        $user = $this->userModel
            ->find($id);
        if (empty($user)) {
            return redirect()->to('/pengguna')
                ->with('alert', [
                    'type' => 'info',
                    'mess' => 'Record dengan id <b>' . $id . '</b> tidak ditemukan!'
                ]);
        }

        site()->setTitle('Edit pengguna')
            ->setBreadcrumb([
                'pengguna' => 'Kelola pengguna',
                'Edit pengguna'
            ]);

        $data = [
            'nama'     => old('nama', $user->nama),
            'username' => old('username', $user->username),
            'password' => old('password'),
            'role'     => old('role', $user->role),
            'roles'    => $this->userModel->getRoles(),
            'edit_id'  => $id,
            'validation' => $this->validation
        ];
        return view('pengguna\v-pengguna-form', $data);
    }

    public function perbarui(int $id)
    {
        $user = $this->userModel
            ->find($id);
        if (empty($user)) {
            return redirect()->to('/pengguna')
                ->with('alert', [
                    'type' => 'info',
                    'mess' => 'Record dengan id <b>' . $id . '</b> tidak ditemukan!'
                ]);
        }

        $request = $this->request;
        $data = [
            'user_id'  => esc($user->user_id),
            'nama'     => esc($request->getPost('nama')),
            'username' => esc($request->getPost('username')),
            'role'     => esc($request->getPost('role')),
        ];

        if (!empty($request->getPost('password'))) {
            $data['password'] = esc($request->getPost('password'));
        }

        $rules = $this->userModel
            ->getValidationRules();
        $valid = $this->validation
            ->setRules($rules)
            ->run($data);

        if ($valid) {
            $this->userModel->save($data);
            return redirect()->to('/pengguna')
                ->with('alert', [
                    'type' => 'success',
                    'mess' => '<i class="fa fa-check"></i> Berhasil memperbarui data pengguna'
                ]);
        }
        return redirect()->back()
            ->withInput();
    }

    //--------------------------------------------------------------------
    public function hapus(int $id)
    {
        $user = $this->userModel
            ->find($id);

        $this->response
            ->setHeader(csrf_header(), csrf_hash());

        if ($user) {
            $delete = $this->userModel->delete($id);
            if ($delete) {
                return $this->response
                    ->setJSON([
                        'status' => 200,
                        'error' => null,
                        'data' => $user,
                        'message' => 'Berhasil menghapus record dengan id <b>' . $user->user_id . '</b>'
                    ]);
            }

            return $this->response
                ->setStatusCode(403)
                ->setJSON([
                    'success' => 403,
                    'error' => true,
                    'data' => null,
                    'message' => 'Terjadi kesalahan saat menghapus record dengan id <b>' . $user->user_id . '</b>'
                ]);
        }

        return $this->response
            ->setStatusCode(404)
            ->setJSON([
                'status' => 404,
                'error' => true,
                'data' => null,
                'message' => 'Tidak ditemukan record dengan id <b>' . $id . '</b>'
            ]);
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
