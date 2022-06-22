<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Toko extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id_toko' => [
				'type' 		 	 => 'INT',
				'constraint' 	 => 11,
				'unsigned' 		 => true,
				'auto_increment' => true,
			],
			'nama_toko' => [
				'type' 			 => 'VARCHAR',
				'constraint' 	 => '255'
			],
			'alamat_toko' => [
				'type' 			 => 'TEXT'
			],
			'telp' => [
				'type' 			 => 'VARCHAR',
				'constraint' 	 => '255'
			],
			'nama_pemilik' => [
				'type' 			 => 'VARCHAR',
				'constraint' 	 => '255'
			],
			'updated_at' => [
				'type'           => 'DATETIME',
				'null'           => true,
			],
		]);

		$this->forge->addKey('id_toko', true);
		$this->forge->createTable('profil');
	}

	public function down()
	{
		//
	}
}
