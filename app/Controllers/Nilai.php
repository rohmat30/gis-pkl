<?php

namespace App\Controllers;

use App\Models\JadwalModel;
use App\Models\NilaiModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\I18n\Time;
use Config\Services;

class Nilai extends BaseController
{
    protected $nilaiModel;
    protected $jadwalModel;
    protected $validation;

    public function __construct()
    {
        $this->nilaiModel = new NilaiModel;
        $this->jadwalModel = new JadwalModel;
        $this->validation = Services::validation();
    }

    public function index()
    {
        site()->setTitle('Kelola Nilai')
            ->setBreadcrumb('Kelola Nilai');
        return view('nilai\v-nilai-index');
    }

    public function json()
    {
        return $this->nilaiModel
            ->datatables();
    }

    //--------------------------------------------------------------------
    public function detail(int $jadwal_id)
    {
        if (!$this->request->isAJAX()) {
            throw PageNotFoundException::forPageNotFound();
        }
        $data = [
            'row' => $this->nilaiModel
                ->detail($jadwal_id)
        ];
        return view('nilai\v-nilai-detail', $data);
    }

    //--------------------------------------------------------------------
    public function select2Siswa()
    {
        if (!$this->request->isAJAX()) {
            throw PageNotFoundException::forPageNotFound();
        }

        $term = $this->request->getVar('term');
        $data = $this->nilaiModel->select2($term);
        return $this->response
            ->setJSON($data);
    }
    //--------------------------------------------------------------------

    public function tambah()
    {
        site()->setTitle('Buat penilaian')
            ->setBreadcrumb([
                'nilai' => 'Kelola nilai',
                'Buat penilaian'
            ]);
        $jadwal = $this->jadwalModel
            ->where(['jadwal_id' => old('jadwal_id')])
            ->join('users', 'users.user_id = jadwal.siswa_id')
            ->first();
        $data = [
            'jadwal_id' => old('jadwal_id'),
            'tanggal'   => old('tanggal', Time::today()->toLocalizedString('dd/MM/YYYY')),
            'kehadiran' => old('kehadiran'),
            'nilai_kehadiran'    => old('nilai_kehadiran'),
            'nilai_lapangan'     => old('nilai_lapangan'),
            'nilai_keterampilan' => old('nilai_keterampilan'),
            'grade'      => old('grade'),
            'keterangan' => old('keterangan'),
            'jadwal' => $jadwal ? [$jadwal->jadwal_id => $jadwal->nama] : [],
            'validation' => $this->validation
        ];
        return view('nilai\v-nilai-form', $data);
    }

    public function simpan()
    {
        $request = $this->request;
        $valid = $this->validate([
            'jadwal_id' => 'required|is_not_unique[jadwal.jadwal_id]',
            'tanggal'   => 'required|valid_date[d/m/Y]',
            'kehadiran' => 'required|is_natural_no_zero',
            'nilai_kehadiran' => 'required|is_natural_no_zero|less_than_equal_to[100]',
            'nilai_lapangan'  => 'required|is_natural_no_zero|less_than_equal_to[100]',
            'nilai_keterampilan' => 'required|is_natural_no_zero|less_than_equal_to[100]',
            'grade' => 'required|in_list[a,b,c,d,e]',
        ]);

        if ($valid) {
            $data = [
                'tanggal' => Time::createFromFormat('d/m/Y', $request->getPost('tanggal')),
                'kehadiran' => esc($request->getPost('kehadiran')),
                'nilai_kehadiran' => esc($request->getPost('nilai_kehadiran')),
                'nilai_keterampilan' => esc($request->getPost('nilai_keterampilan')),
                'nilai_lapangan' => esc($request->getPost('nilai_lapangan')),
                'grade' => esc($request->getPost('grade')),
                'keterangan' => esc($request->getPost('keterangan')),
                'jadwal_id' => esc($request->getPost('jadwal_id')),
            ];
            $this->nilaiModel->save($data);
            return redirect()->to('/nilai')
                ->with('alert', [
                    'type' => 'success',
                    'mess' => 'Berhasil melakukan penilaian untuk siswa'
                ]);
        }
        return redirect()->back()
            ->withInput();
    }

    //--------------------------------------------------------------------
    public function edit(int $id)
    {
        $nilai = $this->nilaiModel
            ->find($id);
        if (empty($nilai)) {
            return redirect()->to('/nilai')
                ->with('alert', [
                    'type' => 'warning',
                    'mess' => 'Tidak ditemukan record dengan id <b>' . $id . '</b>'
                ]);
        }

        site()->setTitle('Ubah penilaian')
            ->setBreadcrumb([
                'nilai' => 'Kelola nilai',
                'Ubah penilaian'
            ]);

        $jadwal = $this->jadwalModel
            ->where(['jadwal_id' => $nilai->jadwal_id])
            ->join('users', 'users.user_id = jadwal.siswa_id')
            ->first();

        $data = [
            'nama_siswa' => $jadwal->nama,
            'tanggal'   => old('tanggal', Time::createFromFormat('Y-m-d', $nilai->tanggal)->toLocalizedString('dd/MM/YYYY')),
            'kehadiran' => old('kehadiran', $nilai->kehadiran),
            'nilai_kehadiran'    => old('nilai_kehadiran', $nilai->nilai_kehadiran),
            'nilai_lapangan'     => old('nilai_lapangan', $nilai->nilai_lapangan),
            'nilai_keterampilan' => old('nilai_keterampilan', $nilai->nilai_keterampilan),
            'grade'      => old('grade', $nilai->grade),
            'keterangan' => old('keterangan', $nilai->keterangan),
            'validation' => $this->validation,
            'nilai_id' => $nilai->nilai_id
        ];
        return view('nilai\v-nilai-form', $data);
    }

    public function perbarui(int $id)
    {
        $nilai = $this->nilaiModel
            ->find($id);
        if (empty($nilai)) {
            return redirect()->to('/nilai')
                ->with('alert', [
                    'type' => 'warning',
                    'mess' => 'Tidak ditemukan record dengan id <b>' . $id . '</b>'
                ]);
        }

        $request = $this->request;
        $valid = $this->validate([
            'tanggal'   => 'required|valid_date[d/m/Y]',
            'kehadiran' => 'required|is_natural_no_zero',
            'nilai_kehadiran' => 'required|is_natural_no_zero|less_than_equal_to[100]',
            'nilai_lapangan'  => 'required|is_natural_no_zero|less_than_equal_to[100]',
            'nilai_keterampilan' => 'required|is_natural_no_zero|less_than_equal_to[100]',
            'grade' => 'required|in_list[a,b,c,d,e]',
        ]);

        if ($valid) {
            $data = [
                'tanggal' => Time::createFromFormat('d/m/Y', $request->getPost('tanggal')),
                'kehadiran' => esc($request->getPost('kehadiran')),
                'nilai_kehadiran' => esc($request->getPost('nilai_kehadiran')),
                'nilai_keterampilan' => esc($request->getPost('nilai_keterampilan')),
                'nilai_lapangan' => esc($request->getPost('nilai_lapangan')),
                'grade' => esc($request->getPost('grade')),
                'keterangan' => esc($request->getPost('keterangan')),
                'nilai_id' => esc($nilai->nilai_id)
            ];
            $this->nilaiModel->save($data);
            return redirect()->to('/nilai')
                ->with('alert', [
                    'type' => 'success',
                    'mess' => 'Berhasil melakukan penilaian untuk siswa'
                ]);
        }
        return redirect()->back()
            ->withInput();
    }
}
