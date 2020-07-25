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


    public function geojson()
    {
        $sql = $this->selectCount('jadwal.jadwal_id', 'jumlah_siswa')
            ->select('instansi.instansi_id')
            ->join('jadwal', 'instansi.instansi_id = jadwal.instansi_id')
            ->groupStart()
            ->where('tanggal_awal <=', 'DATE(NOW())', FALSE)
            ->where('tanggal_akhir >=', 'DATE(NOW())', FALSE)
            ->groupEnd()
            ->where('jadwal.deleted_at IS NULL')
            ->groupBy('instansi.instansi_id')
            ->getCompiledSelect();
        $sql_alias = '(' . $sql . ') as a';
        $rows = $this->select('instansi.*,coalesce(a.jumlah_siswa, 0) as jumlah_siswa')
            ->join($sql_alias, 'a.instansi_id = instansi.instansi_id', 'LEFT')
            ->findAll();

        $results = [
            "type" => "FeatureCollection",
            "name" => "Lokasi Prakerin",
            "crs" => [
                "type" => "name",
                "properties" => [
                    "name" => "urn:ogc:def:crs:OGC:1.3:CRS84"
                ]
            ],
            "features" => []
        ];
        foreach ($rows as $key => $row) {
            $result = [
                "type" => "Feature",
                "properties" => [
                    "name" => $row->nama_instansi,
                    "address" => $row->alamat,
                    "status" => $row->status,
                    "photo" => base_url(['uploads', $row->foto]),
                    "students" => intval($row->jumlah_siswa)
                ],
                "geometry" => [
                    "type" => "Point",
                    "coordinates" => [
                        $row->longitude + 0,
                        $row->latitude + 0
                    ]
                ]
            ];
            $results["features"][$key] = $result;
        }

        return $results;
    }
}
