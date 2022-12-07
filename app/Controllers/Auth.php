<?php

namespace App\Controllers;

class Auth extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'RestoServe || Login',
            'validation' => \Config\Services::validation()
        ];
        return view('auth/login', $data);
    }
}
