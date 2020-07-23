<?php

namespace App\Controllers;

use App\Models\InstansiModel;
use App\Models\JadwalModel;
use App\Models\UserModel;
use App\Models\ViewJadwalModel;
use CodeIgniter\I18n\Time;
use Config\Services;

class Jadwal extends BaseController
{
    protected $jadwalModel;
    protected $viewJadwalModel;
    protected $userModel;
    protected $instansiModel;
    protected $validation;
    public function __construct()
    {
        $this->jadwalModel = new JadwalModel;
        $this->viewJadwalModel = new ViewJadwalModel;
        $this->userModel = new UserModel;
        $this->instansiModel = new InstansiModel;
        $this->validation = Services::validation();
    }

    public function index()
    {
        site()->setTitle('Kelola jadwal &amp; tempat')
            ->setBreadcrumb('Kelola jadwal &amp; tempat');
        return view('jadwal\v-jadwal-index');
    }

    public function json()
    {
        return $this->viewJadwalModel
            ->datatables();
    }

    public function tambah()
    {
        site()->setTitle('Tambah jadwal')
            ->setBreadcrumb([
                'jadwal' => 'Kelola jadwal &amp; tempat',
                'Tambah jadwal'
            ]);

        $user = $this->userModel
            ->select('user_id,nama');

        //siswa
        $siswaSelect = $user
            ->where(['role' => 'siswa', 'user_id' => old('siswa_id')])
            ->first();
        // pembimbing
        $pembimbingSelect = $user
            ->where(['role' => 'pembimbing', 'user_id' => old('pembimbing_id')])
            ->first();
        // pl
        $pembimbingLapanganSelect = $user
            ->where(['role' => 'pembimbing_lapangan', 'user_id' => old('pl_id')])
            ->first();

        // instansi
        $instansiSelect = $this->instansiModel
            ->select('instansi_id,nama_instansi')
            ->where(['instansi_id' => old('instansi_id')])
            ->first();

        // data
        $data = [
            'tanggal_awal'  => old('tanggal_awal', Time::today()->toLocalizedString('dd/MM/YYYY')),
            'tanggal_akhir' => old('tanggal_akhir', Time::today()->toLocalizedString('dd/MM/YYYY')),
            'siswa_id'      => old('siswa_id'),
            'instansi_id'   => old('instansi_id'),
            'pembimbing_id' => old('pembimbing_id'),
            'pl_id'         => old('pl_id'),
            'siswa'         => isset($siswaSelect) ? [$siswaSelect->user_id => $siswaSelect->nama] : [],
            'pembimbing'    => isset($pembimbingSelect) ? [$pembimbingSelect->user_id => $pembimbingSelect->nama] : [],
            'pl'            => isset($pembimbingLapanganSelect) ? [$pembimbingLapanganSelect->user_id => $pembimbingLapanganSelect->nama] : [],
            'instansi'      => isset($instansiSelect) ? [$instansiSelect->instansi_id => $instansiSelect->nama_instansi] : [],
            'validation' => $this->validation
        ];

        return view('jadwal\v-jadwal-form', $data);
    }

    public function simpan()
    {
        $request = $this->request;
        $valid = $this->validate([
            'tanggal_awal'  => 'required|valid_date[d/m/Y]',
            'tanggal_akhir' => 'required|valid_date[d/m/Y]',
            'siswa_id'      => 'required|integer',
            'instansi_id'   => 'required|integer',
            'pembimbing_id' => 'required|integer',
            'pl_id'         => 'required|integer',
        ]);
        if ($valid) {
            $this->jadwalModel->save([
                'tanggal_awal'  => Time::createFromFormat('d/m/Y', esc($request->getPost('tanggal_awal')))->toLocalizedString('YYYY-MM-dd'),
                'tanggal_akhir' => Time::createFromFormat('d/m/Y', esc($request->getPost('tanggal_akhir')))->toLocalizedString('YYYY-MM-dd'),
                'siswa_id'      => esc($request->getPost('siswa_id')),
                'instansi_id'   => esc($request->getPost('instansi_id')),
                'pembimbing_id' => esc($request->getPost('pembimbing_id')),
                'pl_id'         => esc($request->getPost('pl_id')),
            ]);
            return redirect()->to('/jadwal')
                ->with('alert', [
                    'type' => 'success',
                    'mess' => 'Jadwal berhasil ditambahkan!'
                ]);
        }

        return redirect()->back()
            ->withInput();
    }


    public function edit(int $id)
    {
        $jadwal = $this->jadwalModel->find($id);
        if (empty($jadwal)) {
            return redirect()->to('jadwal')
                ->with('alert', [
                    'type' => 'warning',
                    'mess' => 'Record dengan id <b>' . $id . '</b> tidak ditemukan!'
                ]);
        }
        site()->setTitle('Ubah jadwal')
            ->setBreadcrumb([
                'jadwal' => 'Kelola jadwal &amp; tempat',
                'Ubah jadwal'
            ]);

        $user = $this->userModel
            ->select('user_id,nama');

        //siswa
        $siswaSelect = $user
            ->where(['role' => 'siswa', 'user_id' => old('siswa_id', $jadwal->siswa_id)])
            ->first();
        // pembimbing
        $pembimbingSelect = $user
            ->where(['role' => 'pembimbing', 'user_id' => old('pembimbing_id', $jadwal->pembimbing_id)])
            ->first();
        // pl
        $pembimbingLapanganSelect = $user
            ->where(['role' => 'pembimbing_lapangan', 'user_id' => old('pl_id', $jadwal->pl_id)])
            ->first();

        // instansi
        $instansiSelect = $this->instansiModel
            ->select('instansi_id,nama_instansi')
            ->where(['instansi_id' => old('instansi_id', $jadwal->instansi_id)])
            ->first();

        // data
        $data = [
            'tanggal_awal'  => old('tanggal_awal', Time::createFromFormat('Y-m-d', $jadwal->tanggal_awal)->toLocalizedString('dd/MM/YYYY')),
            'tanggal_akhir' => old('tanggal_akhir', Time::createFromFormat('Y-m-d', $jadwal->tanggal_akhir)->toLocalizedString('dd/MM/YYYY')),
            'siswa_id'      => old('siswa_id', $jadwal->siswa_id),
            'instansi_id'   => old('instansi_id', $jadwal->instansi_id),
            'pembimbing_id' => old('pembimbing_id', $jadwal->pembimbing_id),
            'pl_id'         => old('pl_id', $jadwal->pl_id),
            'siswa'         => isset($siswaSelect) ? [$siswaSelect->user_id => $siswaSelect->nama] : [],
            'pembimbing'    => isset($pembimbingSelect) ? [$pembimbingSelect->user_id => $pembimbingSelect->nama] : [],
            'pl'            => isset($pembimbingLapanganSelect) ? [$pembimbingLapanganSelect->user_id => $pembimbingLapanganSelect->nama] : [],
            'instansi'      => isset($instansiSelect) ? [$instansiSelect->instansi_id => $instansiSelect->nama_instansi] : [],
            'validation'    => $this->validation
        ];

        return view('jadwal\v-jadwal-form', $data);
    }

    public function perbarui(int $id)
    {
        $jadwal = $this->jadwalModel->find($id);
        if (empty($jadwal)) {
            return redirect()->to('jadwal')
                ->with('alert', [
                    'type' => 'warning',
                    'mess' => 'Record dengan id <b>' . $id . '</b> tidak ditemukan!'
                ]);
        }

        $request = $this->request;
        $valid = $this->validate([
            'tanggal_awal'  => 'required|valid_date[d/m/Y]',
            'tanggal_akhir' => 'required|valid_date[d/m/Y]',
            'siswa_id'      => 'required|integer',
            'instansi_id'   => 'required|integer',
            'pembimbing_id' => 'required|integer',
            'pl_id'         => 'required|integer',
        ]);
        if ($valid) {
            $this->jadwalModel->save([
                'tanggal_awal'  => Time::createFromFormat('d/m/Y', esc($request->getPost('tanggal_awal')))->toLocalizedString('YYYY-MM-dd'),
                'tanggal_akhir' => Time::createFromFormat('d/m/Y', esc($request->getPost('tanggal_akhir')))->toLocalizedString('YYYY-MM-dd'),
                'siswa_id'      => esc($request->getPost('siswa_id')),
                'instansi_id'   => esc($request->getPost('instansi_id')),
                'pembimbing_id' => esc($request->getPost('pembimbing_id')),
                'pl_id'         => esc($request->getPost('pl_id')),
                'jadwal_id'     => esc($jadwal->jadwal_id)
            ]);
            return redirect()->to('/jadwal')
                ->with('alert', [
                    'type' => 'success',
                    'mess' => 'Jadwal berhasil diperbaharui!'
                ]);
        }

        return redirect()->back()
            ->withInput();
    }

    //--------------------------------------------------------------------
    public function hapus(int $id)
    {
        $jadwal = $this->jadwalModel
            ->find($id);

        $this->response
            ->setHeader(csrf_header(), csrf_hash());

        if ($jadwal) {
            $delete = $this->jadwalModel->delete($id);
            if ($delete) {
                return $this->response
                    ->setJSON([
                        'status' => 200,
                        'error' => null,
                        'data' => $jadwal,
                        'message' => 'Berhasil menghapus record dengan id <b>' . $jadwal->jadwal_id . '</b>'
                    ]);
            }

            return $this->response
                ->setStatusCode(403)
                ->setJSON([
                    'success' => 403,
                    'error' => true,
                    'data' => null,
                    'message' => 'Terjadi kesalahan saat menghapus record dengan id <b>' . $jadwal->jadwal_id . '</b>'
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
    public function select2User(string $role)
    {
        $role = str_replace('-', '_', $role);
        $term = $this->request->getVar('term') ?? '';
        $results = $this->userModel
            ->select2($term, $role);

        return $this->response
            ->setJSON($results);
    }

    public function select2Instansi()
    {
        $term = $this->request->getVar('term') ?? '';

        $results = $this->instansiModel
            ->select2($term);
        return $this->response
            ->setJSON($results);
    }
}
