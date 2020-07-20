<?php

namespace App\Models;

use App\Libraries\Datatables;
use CodeIgniter\Model;

class PengajuanModel extends Model
{
    protected $table      = 'pengajuan_instansi';
    protected $primaryKey = 'pengajuan_id';

    protected $returnType     = 'object';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['nama', 'alamat', 'pic', 'foto', 'user_id'];

    protected $useTimestamps = true;

    public function datatables()
    {
        $url = base_url('uploads');
        $dt = new Datatables($this);
        $dt->select('nama,alamat,pic,concat("' . $url . '/",foto) as foto');
        $dt->where('user_id', user()->id);
        return $dt->generate();
    }
}
