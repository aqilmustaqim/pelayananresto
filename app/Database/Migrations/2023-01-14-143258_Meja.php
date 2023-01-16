<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Meja extends Migration
{
    public function up()
    {

        $this->forge->addField([
            'id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => TRUE,
                'auto_increment' => TRUE
            ],
            'nomor_meja'       => [
                'type'           => 'INT',
                'constraint'     => '50'
            ],
            'status_meja'       => [
                'type'           => 'INT',
                'constraint'     => '50'
            ]
        ]);
        $this->forge->addKey('id', TRUE);
        $this->forge->createTable('meja');
    }

    public function down()
    {
        $this->forge->dropTable('meja');
    }
}
