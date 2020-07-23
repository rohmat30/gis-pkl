<?php

namespace App\Models;

use App\Libraries\Datatables;
use CodeIgniter\Model;

class InstansiModel extends Model
{
    protected $table      = 'instansi';
    protected $primaryKey = 'instansi_id';

    protected $returnType     = 'object';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['nama_instansi', 'alamat', 'pic', 'foto', 'status', 'keterangan', 'latitude', 'longitude'];

    protected $useTimestamps = true;

    public function datatables()
    {
        $dt = new Datatables($this);
        $url = base_url('uploads');
        $dt->select('instansi_id, nama_instansi,alamat,pic,status,keterangan,latitude,longitude,concat("' . $url . '/",foto) as foto');
        if (user()->role == "staff_tu") {
            $dt->addColumn('aksi', [
                'edit'  => site_url('lokasi/$1/edit'),
                'hapus' => site_url('lokasi/$1/hapus')
            ], 'instansi_id');
        }
        return $dt->generate();
    }

    public function select2($query)
    {
        $url = base_url('uploads');
        $this->select('instansi_id,nama_instansi,concat("' . $url . '/",foto) as foto');

        $this->groupStart()
            ->orLike('nama_instansi', $query)
            ->groupEnd();

        //order by nama 'blah%'
        $this->orderBy('IF(nama_instansi LIKE "' . $query . '%",1,2) ASC', '', TRUE);
        $this->orderBy('instansi_id', 'ASC');

        return $this->findAll(5);
    }
}
