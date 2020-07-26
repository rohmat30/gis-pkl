<?php

namespace App\Controllers;

use App\Models\InstansiModel;
use Config\Services;

class Lokasi extends BaseController
{
    protected $instansiModel;
    protected $validation;
    public function __construct()
    {
        $this->instansiModel = new InstansiModel;
        $this->validation = Services::validation();
    }

    public function index()
    {
        site()->setTitle('Kelola lokasi')
            ->setBreadcrumb('Kelola lokasi');
        return view('lokasi\v-lokasi-index');
    }


    public function json()
    {
        return $this->instansiModel
            ->datatables();
    }

    //--------------------------------------------------------------------
    public function tambah()
    {

        site()->setTitle('Tambah lokasi')
            ->setBreadcrumb([
                'lokasi' => 'Kelola lokasi',
                'Tambah lokasi'
            ]);

        // untuk ditampikan di view
        $data = [
            'nama_instansi' => old('nama_instansi'),
            'status'        => old('status'),
            'koordinat'     => old('koordinat'),
            'pic'           => old('pic'),
            'alamat'        => old('alamat'),
            'keterangan'    => old('keterangan'),
            'validation'    => $this->validation
        ];

        return view('lokasi\v-lokasi-form', $data);
    }

    public function simpan()
    {
        $validation = $this->validation;
        $request    = $this->request;
        $foto       = $request->getFile('foto');
        $koordinat  = explode(',', esc($request->getPost('koordinat')));
        $rules      = [
            'nama_instansi' => 'required|string',
            'pic'       => 'required|string',
            'alamat'    => 'required|string',
            'status'    => 'required|string',
            'latitude'  => 'required|decimal|less_than_equal_to[90]|greater_than_equal_to[-90]',
            'longitude' => 'required|decimal|less_than_equal_to[180]|greater_than_equal_to[-180]',
            'foto'      => 'uploaded[foto]|is_image[foto]|ext_in[foto,jpg,jpeg,png]|max_size[foto,2048]',
        ];

        $data = [
            'nama_instansi' => esc($request->getPost('nama_instansi')),
            'pic'        => esc($request->getPost('pic')),
            'alamat'     => esc($request->getPost('alamat')),
            'status'     => esc($request->getPost('status')),
            'latitude'   => empty($koordinat[0]) ? NULL : $koordinat[0],
            'longitude'  => empty($koordinat[1]) ? NULL : $koordinat[1],
            'keterangan' => empty(esc($request->getPost('keterangan'))) ? NULL : esc($request->getPost('keterangan'))
        ];

        $valid = $validation->setRules($rules)
            ->run($data);

        if ($valid) {
            $fileName = sha1(uniqid(user()->id . user()->username)) . '.' . $foto->getExtension();
            $data['foto'] = $fileName;
            $save = $this->instansiModel->save($data);

            if ($save) {
                $foto->move(ROOTPATH . '/public/uploads/', $fileName);

                // resize gambar
                Services::image()
                    ->withFile(ROOTPATH . '/public/uploads/' . $fileName)
                    ->resize(320, 320, true)
                    ->save(ROOTPATH . '/public/uploads/' . $fileName);
            }
            return redirect()->to('/lokasi')
                ->with('alert', [
                    'type' => 'success',
                    'mess' => 'Berhasil menambahkan lokasi prakerin.'
                ]);
        }

        return redirect()->back()
            ->withInput();
    }

    //--------------------------------------------------------------------
    public function edit(int $id)
    {
        $instansi = $this->instansiModel
            ->find($id);
        if (empty($instansi)) {
            return redirect()->to('/lokasi')
                ->with('alert', [
                    'type' => 'warning',
                    'mess' => 'Record lokasi dengan id <b>' . $id . '</b> tidak ditemukan!'
                ]);
        }

        site()->setTitle('Perbarui lokasi')
            ->setBreadcrumb([
                'lokasi' => 'Kelola lokasi',
                'Perbarui lokasi'
            ]);

        // untuk ditampikan di view
        $data = [
            'nama_instansi' => old('nama_instansi', $instansi->nama_instansi),
            'status'        => old('status', $instansi->status),
            'koordinat'     => old('koordinat', $instansi->latitude . ',' . $instansi->longitude),
            'pic'           => old('pic', $instansi->pic),
            'alamat'        => old('alamat', $instansi->alamat),
            'keterangan'    => old('keterangan', $instansi->keterangan),
            'default_foto'  => $instansi->foto,
            'validation'    => $this->validation
        ];

        return view('lokasi\v-lokasi-form', $data);
    }

    public function perbarui(int $id)
    {
        $instansi = $this->instansiModel
            ->find($id);
        if (empty($instansi)) {
            return redirect()->to('/lokasi')
                ->with('alert', [
                    'type' => 'warning',
                    'mess' => 'Record lokasi dengan id <b>' . $id . '</b> tidak ditemukan!'
                ]);
        }

        //jumlah instansi dengan nama foto yang sama
        $totalFoto = count($this->instansiModel
            ->where('foto', $instansi->foto)
            ->findAll());

        $validation = $this->validation;
        $request    = $this->request;
        $foto       = $request->getFile('foto');
        $koordinat  = explode(',', esc($request->getPost('koordinat')));
        $rules      = [
            'nama_instansi' => 'required|string',
            'pic'       => 'required|string',
            'alamat'    => 'required|string',
            'status'    => 'required|string',
            'latitude'  => 'required|decimal|less_than_equal_to[90]|greater_than_equal_to[-90]',
            'longitude' => 'required|decimal|less_than_equal_to[180]|greater_than_equal_to[-180]',
            'foto'      => 'is_image[foto]|ext_in[foto,jpg,jpeg,png]|max_size[foto,2048]',
        ];

        $data = [
            'nama_instansi' => esc($request->getPost('nama_instansi')),
            'pic'         => esc($request->getPost('pic')),
            'alamat'      => esc($request->getPost('alamat')),
            'status'      => esc($request->getPost('status')),
            'latitude'    => empty($koordinat[0]) ? NULL : $koordinat[0],
            'longitude'   => empty($koordinat[1]) ? NULL : $koordinat[1],
            'keterangan'  => empty(esc($request->getPost('keterangan'))) ? NULL : esc($request->getPost('keterangan')),
            'instansi_id' => $instansi->instansi_id
        ];

        $valid = $validation->setRules($rules)
            ->run($data);

        if ($valid) {

            if (!empty($foto->getName())) {
                $fileName = sha1(uniqid(user()->id . user()->username)) . '.' . $foto->getExtension();
                $data['foto'] = $fileName;
            }
            $save = $this->instansiModel->save($data);

            if ($save) {

                if (!empty($foto->getName())) {
                    if (file_exists(ROOTPATH . '/public/uploads/' . $instansi->foto) && $totalFoto == 1) {
                        unlink(ROOTPATH . '/public/uploads/' . $instansi->foto);
                    }

                    $foto->move(ROOTPATH . '/public/uploads/', $fileName);

                    // resize gambar
                    Services::image()
                        ->withFile(ROOTPATH . '/public/uploads/' . $fileName)
                        ->resize(320, 320, true)
                        ->save(ROOTPATH . '/public/uploads/' . $fileName);
                }
            }
            return redirect()->to('/lokasi')
                ->with('alert', [
                    'type' => 'success',
                    'mess' => 'Berhasil memperbaharui lokasi prakerin.'
                ]);
        }

        return redirect()->back()
            ->withInput();
    }


    //--------------------------------------------------------------------
    public function hapus(int $id)
    {
        $instansi = $this->instansiModel
            ->find($id);

        $this->response
            ->setHeader(csrf_header(), csrf_hash());

        if ($instansi) {
            $delete = $this->instansiModel->delete($id);
            if ($delete) {
                return $this->response
                    ->setJSON([
                        'status' => 200,
                        'error' => null,
                        'data' => $instansi,
                        'message' => 'Berhasil menghapus record dengan id <b>' . $instansi->instansi_id . '</b>'
                    ]);
            }

            return $this->response
                ->setStatusCode(403)
                ->setJSON([
                    'success' => 403,
                    'error' => true,
                    'data' => null,
                    'message' => 'Terjadi kesalahan saat menghapus record dengan id <b>' . $instansi->instansi_id . '</b>'
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

}
