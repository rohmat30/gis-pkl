<?php

namespace App\Models;

use App\Libraries\Datatables;
use CodeIgniter\Model;

class ViewJadwalModel extends Model
{
    protected $table      = 'v_jadwal';
    protected $primaryKey = 'jadwal_id';

    protected $returnType     = 'object';
    protected $useSoftDeletes = true;

    public function datatables($where = null)
    {
        $dt = new Datatables($this);
        $dt->select('*');
        switch (user()->role) {
            case 'staff_tu':
                $dt->addColumn('aksi', [
                    'edit' => site_url('jadwal/$1/edit'),
                    'hapus' => site_url('jadwal/$1/hapus'),
                ], 'jadwal_id');
                break;
            case 'siswa':
                $dt->where('siswa_id', user()->id);
                break;
            case 'pembimbing':
                $dt->where('pembimbing_id', user()->id);
                break;
            case 'pembimbing_lapangan':
                $dt->where('pl_id', user()->id);
                break;
        }
        return $dt->generate();
    }
}
