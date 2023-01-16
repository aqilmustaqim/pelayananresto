<?php

namespace App\Models;

use CodeIgniter\Model;

class MejaModel extends Model
{
    protected $table      = 'meja';
    protected $allowedFields = ['nomor_meja', 'status_meja'];
}
