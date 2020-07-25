<?php

namespace App\Controllers;

use App\Models\EvaluasiModel;
use App\Models\NilaiModel;
use Config\Services;

class Evaluasi extends BaseController
{
    protected $evaluasiModel;
    protected $nilaiModel;
    protected $validation;
    public function __construct()
    {
        $this->evaluasiModel = new EvaluasiModel;
        $this->nilaiModel = new NilaiModel;
        $this->validation = Services::validation();
    }

    public function index()
    {
        site()->setTitle('Evaluasi')
            ->setBreadcrumb('Evaluasi');
        return view('evaluasi\v-evaluasi-index');
    }

    public function json()
    {
        return $this->evaluasiModel
            ->datatables();
    }

    public function select2Siswa()
    {
        $term = $this->request
            ->getVar('term');

        $data = $this->evaluasiModel->select2($term);
        return $this->response
            ->setJSON($data);
    }

    //--------------------------------------------------------------------

    public function tambah()
    {
        site()->setTitle('Tambah evaluasi')
            ->setBreadcrumb([
                'evaluasi' => 'Evaluasi',
                'Tambah evaluasi'
            ]);

        $nilaiSelect = $this->nilaiModel
            ->join('v_jadwal as jadwal', 'jadwal.jadwal_id = nilai.jadwal_id')
            ->where('nilai_id', old('nilai_id'))
            ->first();

        $data = [
            'nilai_id'   => old('nilai_id'),
            'keterangan' => old('keterangan'),
            'kelulusan'  => old('kelulusan'),
            'hasil_evaluasi' => old('hasil_evaluasi'),
            'nilai' => $nilaiSelect ? [$nilaiSelect->nilai_id => $nilaiSelect->nama_siswa] : [],
            'validation'     => $this->validation
        ];
        return view('evaluasi\v-evaluasi-form', $data);
    }

    public function simpan()
    {
        $request = $this->request;

        $valid = $this->validate([
            'nilai_id'       => 'required|is_not_unique[nilai.nilai_id]',
            'keterangan'     => 'required|string',
            'kelulusan'      => 'required|string',
            'hasil_evaluasi' => 'required|string',
        ]);

        if ($valid) {
            $data = [
                'nilai_id'       => esc($request->getPost('nilai_id')),
                'keterangan'     => esc($request->getPost('keterangan')),
                'kelulusan'      => esc($request->getPost('kelulusan')),
                'hasil_evaluasi' => esc($request->getPost('hasil_evaluasi')),
            ];
            if ($this->evaluasiModel->save($data)) {
                return redirect()->to('/evaluasi')
                    ->with('alert', [
                        'type' => 'success',
                        'mess' => 'Berhasil menambahkan evaluasi'
                    ]);
            }
        }

        return redirect()->back()
            ->withInput();
    }

    //--------------------------------------------------------------------
    public function edit(int $id)
    {
        $evaluasi = $this->evaluasiModel
            ->find($id);
        if (empty($evaluasi)) {
            return redirect()->to('/evaluasi')
                ->with('alert', [
                    'type' => 'warning',
                    'mess' => 'Record dengan id <b>' . $id . '</b> tidak ditemukan'
                ]);
        }

        site()->setTitle('Edit evaluasi')
            ->setBreadcrumb([
                'evaluasi' => 'Evaluasi',
                'Edit evaluasi'
            ]);

        $nilaiSelect = $this->nilaiModel
            ->join('v_jadwal as jadwal', 'jadwal.jadwal_id = nilai.jadwal_id')
            ->where('nilai_id', $evaluasi->nilai_id)
            ->first();

        $data = [
            'nama_siswa' => $nilaiSelect->nama_siswa,
            'keterangan' => old('keterangan', $evaluasi->keterangan),
            'kelulusan'  => old('kelulusan', $evaluasi->kelulusan),
            'hasil_evaluasi' => old('hasil_evaluasi', $evaluasi->hasil_evaluasi),
            'evaluasi_id' => $evaluasi->evaluasi_id,
            'validation'     => $this->validation
        ];
        return view('evaluasi\v-evaluasi-form', $data);
    }

    public function perbarui(int $id)
    {
        $evaluasi = $this->evaluasiModel
            ->find($id);
        if (empty($evaluasi)) {
            return redirect()->to('/evaluasi')
                ->with('alert', [
                    'type' => 'warning',
                    'mess' => 'Record dengan id <b>' . $id . '</b> tidak ditemukan'
                ]);
        }

        $request = $this->request;

        $valid = $this->validate([
            'keterangan'     => 'required|string',
            'kelulusan'      => 'required|string',
            'hasil_evaluasi' => 'required|string',
        ]);

        if ($valid) {
            $data = [
                'keterangan'     => esc($request->getPost('keterangan')),
                'kelulusan'      => esc($request->getPost('kelulusan')),
                'hasil_evaluasi' => esc($request->getPost('hasil_evaluasi')),
                'evaluasi_id'    => $evaluasi->evaluasi_id
            ];
            if ($this->evaluasiModel->save($data)) {
                return redirect()->to('/evaluasi')
                    ->with('alert', [
                        'type' => 'success',
                        'mess' => 'Berhasil menambahkan evaluasi'
                    ]);
            }
        }

        return redirect()->back()
            ->withInput();
    }
}
