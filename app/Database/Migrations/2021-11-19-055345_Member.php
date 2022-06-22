<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Member extends Migration
{
    public function up()
    {
        $this->forge->addField([
			'id_member' => [
				'type' 		 	 => 'INT',
				'constraint' 	 => 11,
				'unsigned' 		 => true,
				'auto_increment' => true,
			],
			'nama_member' => [
				'type' 			 => 'VARCHAR',
				'constraint' 	 => '255'
			],
            'alamat_member' => [
				'type' 			 => 'TEXT'
			],
            'telepon' => [
				'type' 			 => 'VARCHAR',
				'constraint' 	 => '50'
			],
            'email' => [
				'type' 			 => 'VARCHAR',
				'constraint' 	 => '100'
			],
            'gambar' => [
				'type' 			 => 'VARCHAR',
				'constraint' 	 => '255'
			],
            'NIK' => [
				'type' 			 => 'VARCHAR',
				'constraint' 	 => '255'
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

		$this->forge->addKey('id_member', true);
		$this->forge->createTable('member');
    }

    public function down()
    {
        //
    }
}
