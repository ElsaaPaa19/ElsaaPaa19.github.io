<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Keranjang extends Migration
{
    public function up()
    {
        $this->forge->addField([
			'id_keranjang' => [
				'type' 		 	 => 'INT',
				'constraint' 	 => 11,
				'unsigned' 		 => true,
				'auto_increment' => true,
			],
            'id_produk' => [
				'type' 			 => 'VARCHAR',
				'constraint' 	 => '255'
			],
            'id_member' => [
				'type' 			 => 'INT',
				'constraint' 	 => 11
			],
			'harga' => [
				'type' 			 => 'INT',
				'constraint' 	 => 11
			],
            'stok' => [
				'type' 			 => 'INT',
				'constraint' 	 => 11
			],
            'qty' => [
				'type' 			 => 'INT',
				'constraint' 	 => 11
			],
            'total' => [
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

        $this->forge->addKey('id_keranjang', true);
		$this->forge->createTable('keranjang');
    }

    public function down()
    {
        //
    }
}
