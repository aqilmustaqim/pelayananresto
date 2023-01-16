<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PenjualanDetail extends Migration
{
    public function up()
    {
        //id, invoice, tanggal, kode_produk , Pelanggan , total_kotor, total_bersih

        $this->forge->addField([
            'id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => TRUE,
                'auto_increment' => TRUE
            ],
            'invoice'       => [
                'type'           => 'INT',
                'constraint'     => '128'
            ],
            'id_produk'       => [
                'type'           => 'INT',
                'constraint'     => '50'
            ],
            'harga_beli'       => [
                'type'           => 'INT',
                'constraint'     => '50'
            ],
            'harga_jual'       => [
                'type'           => 'INT',
                'constraint'     => '50'
            ],
            'jumlah'       => [
                'type'           => 'INT',
                'constraint'     => '50'
            ],
            'subtotal'       => [
                'type'           => 'INT',
                'constraint'     => '128'
            ],
            'status_menu' => [
                'type'           => 'INT',
                'constraint'     => '50'
            ],

        ]);
        $this->forge->addKey('id', TRUE);
        $this->forge->createTable('penjualan_detail');
    }

    public function down()
    {
        $this->forge->dropTable('penjualan_detail');
    }
}
