<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Evaluasi extends Migration
{
	protected $table = 'evaluasi';
	public function up()
	{
		//
		$this->forge
			->addPrimaryKey('evaluasi_id')
			->addField([
				'evaluasi_id' => [
					'type'           => 'INT',
					'constraint'     => 11,
					'unsigned'       => TRUE,
					'auto_increment' => TRUE
				],
				'keterangan' => [
					'type'       => 'VARCHAR',
					'constraint' => 30,
				],
				'kelulusan' => [
					'type'       => 'VARCHAR',
					'constraint' => 10,
				],
				'hasil_evaluasi' => [
					'type'       => 'VARCHAR',
					'constraint' => 100,
				],
				'nilai_id' => [
					'type'           => 'INT',
					'constraint'     => 11,
					'unsigned'       => TRUE,
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
