<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PengajuanInstansi extends Migration
{
	protected $table = 'pengajuan_instansi';
	public function up()
	{
		//
		$this->forge
			->addPrimaryKey('pengajuan_id')
			->addField([
				'pengajuan_id' => [
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
				'user_id' => [
					'type'       => 'INT',
					'constraint' => 11,
					'unsigned'   => TRUE
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
