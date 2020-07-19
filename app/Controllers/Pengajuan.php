<?php

namespace App\Controllers;

use App\Models\PengajuanModel;
use Config\Services;

class Pengajuan extends BaseController
{
    protected $pengajuanModel;
    protected $validation;
    public function __construct()
    {
        $this->pengajuanModel = new PengajuanModel;
        $this->validation = Services::validation();
    }

    public function index()
    {
        site()->setTitle('Pengajuan Instansi')
            ->setBreadcrumb('Pengajuan Instansi');
        return view('pengajuan\v-pengajuan-index');
    }

    public function json()
    {
        return $this->pengajuanModel
            ->datatables();
    }

    //--------------------------------------------------------------------
    public function tambah()
    {
        site()->setTitle('Buat pengajuan')
            ->setBreadcrumb(['pengajuan' => 'Pengajuan Instansi', 'Buat pengajuan']);

        $data = [
            'nama'   => old('nama'),
            'alamat' => old('alamat'),
            'pic'    => old('pic'),
            'validation' => $this->validation
        ];
        return view('pengajuan\v-pengajuan-form', $data);
    }

    public function simpan()
    {
        $validation = $this->validation;
        $request = $this->request;
        $rules = [
            'foto'   => 'uploaded[foto]|is_image[foto]|ext_in[foto,jpg,png]|max_size[foto,2048]',
            'nama'   => 'required|string',
            'pic'    => 'required|string',
            'alamat' => 'required|string',
        ];

        $valid = $validation->withRequest($this->request)
            ->setRules($rules)
            ->run();

        if ($valid) {
            $file = $request->getFile('foto');
            $fileName = sha1(uniqid(user()->id . user()->username)) . '.' . $file->getExtension();
            $data = [
                'foto'    => $fileName,
                'nama'    => esc($request->getPost('nama')),
                'pic'     => esc($request->getPost('pic')),
                'alamat'  => esc($request->getPost('alamat')),
                'status'  => 'menunggu',
                'user_id' => esc(user()->id)
            ];

            $save = $this->pengajuanModel->save($data);
            if ($save) {
                $file->move(ROOTPATH . '/public/uploads/', $fileName);

                // resize gambar
                Services::image()
                    ->withFile(ROOTPATH . '/public/uploads/' . $fileName)
                    ->resize(320, 320, true)
                    ->save(ROOTPATH . '/public/uploads/' . $fileName);
            }

            return redirect()->to('/pengajuan')
                ->with('alert', [
                    'type' => 'success',
                    'mess' => 'Berhasil membuat pengajuan, tunggu konfirmasi oleh kajur.'
                ]);
        }

        return redirect()->back()
            ->withInput();
    }


    //--------------------------------------------------------------------

}
