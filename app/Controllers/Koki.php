<?php

namespace App\Controllers;

use App\Models\UsersModel;

class Koki extends BaseController
{

    protected $usersModel;

    public function __construct()
    {
        $this->usersModel = new UsersModel();
    }

    public function index()
    {
        $data = [
            'title' => 'RestoServe || Dashboard Koki',
            'validation' => \Config\Services::validation()
        ];
        return view('koki/index', $data);
    }
}
