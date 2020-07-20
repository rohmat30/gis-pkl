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

    protected $allowedFields = ['nama_instansi', 'alamat', 'pic', 'foto', 'user_id'];

    protected $useTimestamps = true;

    public function datatables()
    {
        $url = base_url('uploads');
        $dt = new Datatables($this);
        $dt->select('pengajuan_id,pengajuan_instansi.nama_instansi,alamat,pic,concat("' . $url . '/",foto) as foto,users.nama,username');
        $dt->join('users', 'users.user_id = ' . $this->table . '.user_id');
        if (user()->role == 'siswa') {
            $dt->where('users.user_id', user()->id);
        } else {
            $dt->addColumn('action', site_url('persetujuan/$1/tambah'), 'pengajuan_id');
        }
        return $dt->generate();
    }
}
