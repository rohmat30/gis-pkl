<?php

namespace App\Models;

use App\Libraries\Datatables;
use CodeIgniter\Model;

class NilaiModel extends Model
{
    protected $table      = 'nilai';
    protected $primaryKey = 'nilai_id';

    protected $returnType     = 'object';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['tanggal', 'kehadiran', 'nilai_lapangan', 'nilai_keterampilan', 'nilai_kehadiran', 'grade', 'keterangan', 'jadwal_id'];

    protected $useTimestamps = true;

    public function datatables()
    {
        $dt = new Datatables($this);
        $dt->select('*,(nilai_lapangan + nilai_keterampilan + nilai_kehadiran) as total');
        $dt->join('v_jadwal jadwal', 'jadwal.jadwal_id = nilai.jadwal_id');
        $dt->where('jadwal.deleted_at');

        if (user()->role == 'siswa') {
            $dt->where('jadwal.siswa_id', user()->id);
        }

        if (user()->role == 'pembimbing') {
            $dt->where('jadwal.pembimbing_id', user()->id);
        }

        if (user()->role == 'pembimbing_lapangan') {
            $dt->where('jadwal.pl_id', user()->id);
        }

        if (user()->role == 'siswa') {
            $dt->addColumn('aksi', [
                'detail' => site_url('/nilai/$1/detail')
            ], 'nilai_id');
        } else {
            $dt->addColumn('aksi', [
                'edit' => site_url('/nilai/$1/edit'),
                'detail' => site_url('/nilai/$1/detail')
            ], 'nilai_id');
        }

        return $dt->generate();
    }

    public function detail(int $jadwal_id)
    {
        return $this->select('jadwal.*,nilai.*,(nilai_lapangan + nilai_keterampilan + nilai_kehadiran) as nilai_total,s.nama nama_siswa, p.nama nama_pembimbing, pl.nama nama_pl,nama_instansi')
            ->join('jadwal', 'jadwal.jadwal_id = nilai.jadwal_id', 'RIGHT')
            ->join('instansi', 'jadwal.instansi_id = instansi.instansi_id')
            ->join('users s', 'jadwal.siswa_id = s.user_id')
            ->join('users p', 'jadwal.pembimbing_id = p.user_id')
            ->join('users pl', 'jadwal.pl_id = pl.user_id')
            ->where(['jadwal.jadwal_id' => $jadwal_id])
            ->first();
    }

    public function select2($query)
    {
        if (isset($query)) {
            $this->like('s.nama', $query)
                ->orLike('s.username', $query)
                ->orderBy('IF(s.nama LIKE "' . $query . '%",1,2) ASC', '', TRUE);
        }
        if (user()->role == 'pembimbing_lapangan') {
            $this->where('jadwal.pl_id', user()->id);
        }

        if (user()->role == 'pembimbing') {
            $this->where('jadwal.pembimbing_id', user()->id);
        }

        return $this->select('jadwal.jadwal_id,s.nama nama_siswa,s.username')
            ->join('jadwal', 'jadwal.jadwal_id = nilai.jadwal_id', 'RIGHT')
            ->join('users s', 'jadwal.siswa_id = s.user_id')
            ->orderBy('s.user_id ASC')
            ->where('nilai_id')
            ->where('jadwal.deleted_at')
            ->findAll(5);
    }
}
