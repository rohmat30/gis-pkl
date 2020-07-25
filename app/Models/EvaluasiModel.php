<?php

namespace App\Models;

use App\Libraries\Datatables;
use CodeIgniter\Model;

class EvaluasiModel extends Model
{
    protected $table      = 'evaluasi';
    protected $primaryKey = 'evaluasi_id';

    protected $returnType     = 'object';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['nilai_id', 'keterangan', 'kelulusan', 'hasil_evaluasi'];

    protected $useTimestamps = true;

    public function datatables()
    {
        $dt = new Datatables($this);
        $dt->select('evaluasi.*,jadwal.nama_siswa,(nilai.nilai_keterampilan + nilai.nilai_lapangan + nilai.nilai_kehadiran) as total');
        $dt->join('nilai', 'nilai.nilai_id = evaluasi.nilai_id');
        $dt->join('v_jadwal as jadwal', 'jadwal.jadwal_id = nilai.jadwal_id');
        if (user()->role == 'kajur') {
            $dt->addColumn('aksi', ['edit' => site_url('/evaluasi/$1/edit')], 'evaluasi_id');
        }

        if (user()->role == 'pembimbing') {
            $dt->where('jadwal.pembimbing_id', user()->id);
        }

        return $dt->generate();
    }

    public function select2($query)
    {
        if ($query) {
            $this
                ->groupStart()
                ->like('users.nama', $query)
                ->orLike('users.username', $query)
                ->orderBy('IF(users.nama LIKE "' . $query . '%",1,2) ASC')
                ->orderBy('nilai_id ASC')
                ->groupEnd();
        }

        return $this
            ->select('nilai.nilai_id,nama,username')
            ->join('nilai', 'nilai.nilai_id = evaluasi.nilai_id', 'RIGHT')
            ->join('jadwal', 'jadwal.jadwal_id = nilai.jadwal_id')
            ->join('users', 'users.user_id = jadwal.siswa_id')
            ->where('jadwal.deleted_at')
            ->where('evaluasi.nilai_id')
            ->where('nilai.deleted_at')
            ->findAll(5);
    }
}
