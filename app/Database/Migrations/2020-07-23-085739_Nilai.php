<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Nilai extends Migration
{
	protected $table = 'nilai';
	public function up()
	{
		//
		$this->forge
			->addPrimaryKey('nilai_id')
			->addField([
				'nilai_id' => [
					'type'           => 'INT',
					'constraint'     => 11,
					'unsigned'       => TRUE,
					'auto_increment' => TRUE
				],
				'tanggal' => [
					'type' => 'DATE',
				],
				'kehadiran' => [
					'type'       => 'SMALLINT',
					'constraint' => 5,
					'unsigned'   => TRUE,
				],
				'nilai_lapangan' => [
					'type'       => 'TINYINT',
					'constraint' => 3,
					'unsigned'   => TRUE,
				],
				'nilai_keterampilan' => [
					'type'       => 'TINYINT',
					'constraint' => 3,
					'unsigned'   => TRUE,
				],
				'nilai_kehadiran' => [
					'type'       => 'TINYINT',
					'constraint' => 3,
					'unsigned'   => TRUE,
				],
				'grade' => [
					'type'       => 'CHAR',
					'constraint' => 1,
				],
				'keterangan' => [
					'type'       => 'VARCHAR',
					'constraint' => 100,
				],
				'jadwal_id' => [
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
