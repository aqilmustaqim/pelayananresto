<?php

namespace App\Models;

use CodeIgniter\Model;

class KategoriModel extends Model
{
    protected $table      = 'kategori_produk';
    protected $allowedFields = ['kategori'];
}
