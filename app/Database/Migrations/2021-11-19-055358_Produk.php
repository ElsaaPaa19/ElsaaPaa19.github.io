<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Produk extends Migration
{
    public function up()
    {
        $this->forge->addField([
			'id' => [
				'type' 		 	 => 'INT',
				'constraint' 	 => 11,
				'unsigned' 		 => true,
				'auto_increment' => true,
			],
            'id_produk' => [
				'type' 			 => 'VARCHAR',
				'constraint' 	 => '255'
			],
            'id_kategori' => [
				'type' 			 => 'INT',
				'constraint' 	 => 11
			],
            'nama_produk' => [
				'type' 			 => 'TEXT'
			],
            'merk' => [
				'type' 			 => 'VARCHAR',
				'constraint' 	 => '255'
			],
            'harga_beli' => [
				'type' 			 => 'INT',
				'constraint' 	 => 11
			],
            'harga_jual' => [
				'type' 			 => 'INT',
				'constraint' 	 => 11
			],
			'satuan_produk' => [
				'type' 			 => 'VARCHAR',
				'constraint' 	 => '50'
			],
            'stok' => [
				'type' 			 => 'INT',
				'constraint' 	 => 11
			],
			'barcode' => [
				'type' 			 => 'VARCHAR',
				'constraint' 	 => '255'
			],
			'id_media' => [
				'type' 			 => 'INT',
				'constraint' 	 => 11
			],
            'created_at' => [
                'type'           => 'DATETIME',
                'null'           => true,
            ],
            'updated_at' => [
                'type'           => 'DATETIME',
                'null'           => true,
            ],
		]);

        $this->forge->addKey('id', true);
		$this->forge->createTable('produk');
    }

    public function down()
    {
        //
    }
}
