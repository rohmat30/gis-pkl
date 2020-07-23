<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ViewJadwal extends Migration
{
	protected $table = 'v_jadwal';
	public function up()
	{
		//
		$sql = 'SELECT jadwal_id,siswa_id,pembimbing_id,pl_id,instansi_id,s.nama nama_siswa,p.nama nama_pembimbing,pl.nama nama_pl,nama_instansi,tanggal_awal,tanggal_akhir,jadwal.deleted_at
			FROM jadwal
			JOIN users s
				ON jadwal.`siswa_id` = s.user_id
			JOIN users pl
				ON jadwal.`pl_id` = pl.user_id
			JOIN users p
				ON jadwal.`pembimbing_id` = p.user_id
			JOIN instansi
				ON instansi.instansi_id =jadwal.`instansi_id`';
		$view = 'CREATE VIEW ' . $this->table . ' AS (' . $sql . ')';
		$this->db->query($view);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		//
		$view = 'DROP VIEW ' . $this->table;
		$this->db->query($view);
	}
}
