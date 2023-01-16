<?php

namespace App\Models;

use CodeIgniter\Model;

class PenjualanDetailModel extends Model
{
    protected $table      = 'penjualan_detail';
    protected $allowedFields = ['invoice', 'id_produk', 'harga_beli', 'harga_jual', 'jumlah', 'subtotal', 'status_menu'];
}
