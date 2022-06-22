<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Media extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id_media' => [
				'type' 		 	 => 'INT',
				'constraint' 	 => 11,
				'unsigned' 		 => true,
				'auto_increment' => true,
			],
			'media_path' => [
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
            'tgl_delete' => [
                'type'           => 'DATETIME',
                'null'           => true,
            ]
		]);

		$this->forge->addKey('id_media', true);
		$this->forge->createTable('media');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('media');
	}
}
