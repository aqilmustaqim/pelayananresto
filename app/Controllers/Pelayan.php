<?php

namespace App\Controllers;

use App\Models\UsersModel;

class Pelayan extends BaseController
{

    protected $usersModel;

    public function __construct()
    {
        $this->usersModel = new UsersModel();
    }

    public function index()
    {
        $data = [
            'title' => 'RestoServe || Dashboard Waiters',
            'validation' => \Config\Services::validation()
        ];
        return view('pelayan/index', $data);
    }
}
