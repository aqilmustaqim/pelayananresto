<?php

namespace App\Models;

use CodeIgniter\Model;

class PenjualanModel extends Model
{
    protected $table      = 'penjualan';
    protected $allowedFields = ['id_meja', 'invoice', 'tanggal', 'pelanggan', 'waiters', 'status_pesanan', 'status_pembayaran', 'total'];
}
