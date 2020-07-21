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
        return $dt->generate();
    }
}
