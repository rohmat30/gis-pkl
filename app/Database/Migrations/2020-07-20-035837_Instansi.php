<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Instansi extends Migration
{
	protected $table = 'instansi';
	public function up()
	{
		//
		$this->forge
			->addPrimaryKey('instansi_id')
			->addField([
				'instansi_id' => [
					'type'           => 'INT',
					'constraint'     => 11,
					'unsigned'       => TRUE,
					'auto_increment' => TRUE
				],
				'nama_instansi' => [
					'type'       => 'VARCHAR',
					'constraint' => 100
				],
				'alamat' => [
					'type'       => 'VARCHAR',
					'constraint' => 255
				],
				'pic' => [
					'type'       => 'VARCHAR',
					'constraint' => 50
				],
				'foto' => [
					'type'       => 'VARCHAR',
					'constraint' => 255
				],
				'status' => [
					'type'       => 'VARCHAR',
					'constraint' => 50
				],
				'keterangan' => [
					'type'       => 'VARCHAR',
					'constraint' => 100,
					'null'       => true
				],
				'latitude' => [
					'type'       => 'DECIMAL',
					'constraint' => '10,6'
				],
				'longitude' => [
					'type'       => 'DECIMAL',
					'constraint' => '10,6',
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
