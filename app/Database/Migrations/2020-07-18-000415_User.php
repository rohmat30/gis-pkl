<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class User extends Migration
{
	private $table = 'users';
	public function up()
	{
		//
		$this->forge
			->addPrimaryKey('user_id')
			->addField([
				'user_id' => [
					'type'           => 'INT',
					'constraint'     => 11,
					'unsigned'       => TRUE,
					'auto_increment' => TRUE
				],
				'nama' => [
					'type'       => 'VARCHAR',
					'constraint' => 50
				],
				'username' => [
					'type'       => 'VARCHAR',
					'constraint' => 20,
					'unique'     => TRUE
				],
				'password' => [
					'type'       => 'VARCHAR',
					'constraint' => 255
				],
				'role'      => [
					'type'       => 'ENUM',
					'constraint' => ['siswa', 'pembimbing', 'pembimbing_lapangan', 'kajur', 'staff_tu'],
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
