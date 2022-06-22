<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Login extends Migration
{
    public function up()
    {
        $this->forge->addField([
			'id_login' => [
				'type' 		 	 => 'INT',
				'constraint' 	 => 11,
				'unsigned' 		 => true,
				'auto_increment' => true,
			],
			'email' => [
				'type' 			 => 'VARCHAR',
				'constraint' 	 => '255'
			],
			'nama' => [
				'type' 			 => 'VARCHAR',
				'constraint' 	 => '255'
			],
            'username' => [
				'type' 			 => 'VARCHAR',
				'constraint' 	 => '255'
			],
            'password' => [
				'type' 			 => 'VARCHAR',
				'constraint' 	 => '255'
			],
            'token' => [
				'type' 			 => 'VARCHAR',
				'constraint' 	 => '255'
			],
            'role' => [
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

		$this->forge->addKey('id_login', true);
		$this->forge->createTable('login');
    }

    public function down()
    {
        //
    }
}
