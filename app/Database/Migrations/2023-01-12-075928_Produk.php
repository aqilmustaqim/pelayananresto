<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Produk extends Migration
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
            'kode_produk'       => [
                'type'           => 'VARCHAR',
                'constraint'     => '50'
            ],
            'nama_produk'       => [
                'type'           => 'VARCHAR',
                'constraint'     => '50'
            ],
            'kategori_produk_id'       => [
                'type'           => 'INT',
                'constraint'     => '11'
            ],
            'stok_produk'       => [
                'type'           => 'INT',
                'constraint'     => '11'
            ],
            'modal_produk'       => [
                'type'           => 'INT',
                'constraint'     => '11'
            ],
            'harga_produk'       => [
                'type'           => 'INT',
                'constraint'     => '11'
            ],
            'foto_produk'       => [
                'type'           => 'VARCHAR',
                'constraint'     => '50'
            ],
            'keterangan_produk'       => [
                'type'           => 'text',
                'constraint'     => '500'
            ]
        ]);
        $this->forge->addKey('id', TRUE);
        $this->forge->createTable('produk');
    }

    public function down()
    {
        $this->forge->dropTable('produk');
    }
}
