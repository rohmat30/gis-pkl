<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Jadwal extends Migration
{
	protected $table = 'jadwal';
	public function up()
	{
		//
		$this->forge
			->addPrimaryKey('jadwal_id')
			->addField([
				'jadwal_id' => [
					'type'           => 'INT',
					'constraint'     => 11,
					'unsigned'       => TRUE,
					'auto_increment' => TRUE
				],
				'tanggal_awal' => [
					'type' => 'DATE',
				],
				'tanggal_akhir' => [
					'type' => 'DATE',
				],
				'instansi_id' => [
					'type'       => 'INT',
					'constraint' => 11,
					'unsigned'   => TRUE,
				],
				'pembimbing_id' => [
					'type'       => 'INT',
					'constraint' => 11,
					'unsigned'   => TRUE,
				],
				'pl_id' => [
					'type'       => 'INT',
					'constraint' => 11,
					'unsigned'   => TRUE,
				],
				'siswa_id' => [
					'type'       => 'INT',
					'constraint' => 11,
					'unsigned'   => TRUE,
				],
				'created_at' => [
					'type' => 'DATETIME',
					'null' => TRUE
				],
				'updated_at' => [
					'type' => 'DATETIME',
					'null' => TRUE
				],
				'deleted_at' => [
					'type' => 'DATETIME',
					'null' => TRUE
				]
			])
			->createTable($this->table);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		//
		$this->forge->dropTable($this->table);
	}
}
