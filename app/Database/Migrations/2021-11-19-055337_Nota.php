<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Nota extends Migration
{
    public function up()
    {
        $this->forge->addField([
			'id_nota' => [
				'type' 		 	 => 'INT',
				'constraint' 	 => 11,
				'unsigned' 		 => true,
				'auto_increment' => true,
			],
            'no_nota' => [
				'type' 		 	 => 'INT',
				'constraint' 	 => 11,
			],
            'id_member' => [
				'type' 		 	 => 'INT',
				'constraint' 	 => 11,
			],
            'jumlah' => [
				'type' 		 	 => 'INT',
				'constraint' 	 => 11,
			],
            'total' => [
				'type' 		 	 => 'INT',
				'constraint' 	 => 11,
			],
			'bayar' => [
				'type' 		 	 => 'INT',
				'constraint' 	 => 11,
			],
			'kembali' => [
				'type' 		 	 => 'INT',
				'constraint' 	 => 11,
			],
            'periode' => [
				'type' 			 => 'VARCHAR',
				'constraint' 	 => '255'
			],
			'id_user' => [
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

		$this->forge->addKey('id_nota', true);
		$this->forge->createTable('nota');
    }

    public function down()
    {
        //
    }
}
