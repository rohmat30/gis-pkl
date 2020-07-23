<?php

namespace App\Models;

use App\Libraries\Datatables;
use CodeIgniter\Model;

class JadwalModel extends Model
{
    protected $table      = 'jadwal';
    protected $primaryKey = 'jadwal_id';

    protected $returnType     = 'object';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['tanggal_awal', 'tanggal_akhir', 'instansi_id', 'pembimbing_id', 'pl_id', 'siswa_id'];

    protected $useTimestamps = true;

    public function datatables()
    {
        $dt = new Datatables($this);
        return $dt->generate();
    }
}
