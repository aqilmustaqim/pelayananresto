<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Penjualan extends Migration
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
            'id_meja'       => [
                'type'           => 'INT',
                'constraint'     => '50'
            ],
            'invoice'       => [
                'type'           => 'INT',
                'constraint'     => '128'
            ],
            'tanggal'       => [
                'type'           => 'DATE'
            ],
            'pelanggan' => [
                'type'           => 'VARCHAR',
                'constraint'     => '128'
            ],
            'total' => [
                'type'           => 'INT',
                'constraint'     => '128'
            ],
            'status_pesanan' => [
                'type'           => 'INT',
                'constraint'     => '50'
            ],
            'status_pembayaran' => [
                'type'           => 'INT',
                'constraint'     => '50'
            ],
            'waiters' => [
                'type'           => 'VARCHAR',
                'constraint'     => '128'
            ]
        ]);
        $this->forge->addKey('id', TRUE);
        $this->forge->createTable('penjualan');
    }

    public function down()
    {
        $this->forge->dropTable('penjualan');
    }
}
