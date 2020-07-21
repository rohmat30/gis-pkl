<?php

namespace App\Controllers;

use App\Models\InstansiModel;
use App\Models\PengajuanModel;
use Config\Services;

class Persetujuan extends BaseController
{
    protected $pengajuanModel;
    protected $instansiModel;
    protected $validation;
    public function __construct()
    {
        $this->pengajuanModel = new PengajuanModel;
        $this->instansiModel = new InstansiModel();
        $this->validation = Services::validation();
    }

    public function index()
    {
        site()->setTitle('Persetujuan Instansi')
            ->setBreadcrumb('Persetujuan Instansi');
        return view('persetujuan\v-persetujuan-index');
    }


    public function json()
    {
        return $this->instansiModel
            ->datatables();
    }

    //--------------------------------------------------------------------
    public function tambah(int $pengajuan_id)
    {
        $pengajuan = $this->pengajuanModel->find($pengajuan_id);

        // cek persetujuan berdasarkan pengajuan
        if (empty($pengajuan)) {
            return redirect()->to('/persetujuan')
                ->with('alert', [
                    'type' => 'warning',
                    'mess' => 'Tidak ditemukan pengajuan dengan id <b>' . $pengajuan_id . '</b>'
                ]);
        }

        site()->setTitle('Buat peresetujuan')
            ->setBreadcrumb([
                'persetujuan' => 'Persetujaun Instansi',
                'Buat persetujuan'
            ]);

        // untuk ditampikan di view
        $data = [
            'nama_instansi' => old('nama_instansi', $pengajuan->nama_instansi),
            'status'        => old('status'),
            'koordinat'     => old('koordinat'),
            'pic'           => old('pic', $pengajuan->pic),
            'alamat'        => old('alamat', $pengajuan->alamat),
            'keterangan'    => old('keterangan'),
            'foto'          => base_url(['uploads', $pengajuan->foto]),
            'validation'    => $this->validation
        ];

        return view('persetujuan\v-persetujuan-form', $data);
    }

    public function simpan(int $pengajuan_id)
    {
        $pengajuan = $this->pengajuanModel->find($pengajuan_id);

        // cek persetujuan berdasarkan pengajuan
        if (empty($pengajuan)) {
            return redirect()->to('/persetujuan')
                ->with('alert', [
                    'type' => 'warning',
                    'mess' => 'Tidak ditemukan pengajuan dengan id <b>' . $pengajuan_id . '</b>'
                ]);
        }

        $validation = $this->validation;
        $request = $this->request;
        $koordinat = explode(',', esc($request->getPost('koordinat')));
        $rules = [
            'nama_instansi' => 'required|string',
            'pic'       => 'required|string',
            'alamat'    => 'required|string',
            'status'    => 'required|string',
            'latitude'  => 'required|decimal|less_than_equal_to[90]|greater_than_equal_to[-90]',
            'longitude' => 'required|decimal|less_than_equal_to[180]|greater_than_equal_to[-180]',
        ];

        $data = [
            'nama_instansi' => esc($request->getPost('nama_instansi')),
            'pic'        => esc($request->getPost('pic')),
            'alamat'     => esc($request->getPost('alamat')),
            'status'     => esc($request->getPost('status')),
            'latitude'   => empty($koordinat[0]) ? NULL : $koordinat[0],
            'longitude'  => empty($koordinat[1]) ? NULL : $koordinat[1],
            'keterangan' => empty(esc($request->getPost('keterangan'))) ? NULL : esc($request->getPost('keterangan')),
            'foto'       => $pengajuan->foto
        ];

        $valid = $validation->setRules($rules)
            ->run($data);

        if ($valid) {
            $save = $this->instansiModel->save($data);
            return redirect()->to('/persetujuan')
                ->with('alert', [
                    'type' => 'success',
                    'mess' => 'Berhasil membuat persetujuan tempat prakerin.'
                ]);
        }

        return redirect()->back()
            ->withInput();
    }


    //--------------------------------------------------------------------

}
