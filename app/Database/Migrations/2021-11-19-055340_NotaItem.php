<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class NotaItem extends Migration
{
    public function up()
    {
        $this->forge->addField([
			'id_notaitem' => [
				'type' 		 	 => 'INT',
				'constraint' 	 => 11,
				'unsigned' 		 => true,
				'auto_increment' => true,
			],
			'id_produk' => [
				'type' 			 => 'VARCHAR',
				'constraint' 	 => '255'
			],
            'id_nota' => [
				'type' 		 	 => 'INT',
				'constraint' 	 => 11,
			],
			'harga' => [
				'type' 		 	 => 'INT',
				'constraint' 	 => 11,
			],
            'qty' => [
				'type' 		 	 => 'INT',
				'constraint' 	 => 11,
			],
            'jumlah' => [
				'type' 		 	 => 'INT',
				'constraint' 	 => 11,
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

		$this->forge->addKey('id_notaitem', true);
		$this->forge->createTable('nota_item');
    }

    public function down()
    {
        //
    }
}
