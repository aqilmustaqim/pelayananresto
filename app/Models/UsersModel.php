<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model
{
    protected $table      = 'users';
    protected $primaryKey = 'id';
    protected $useTimestamps = true;
    protected $allowedFields = ['nama', 'email', 'password', 'role_id', 'foto', 'is_active',];
}
