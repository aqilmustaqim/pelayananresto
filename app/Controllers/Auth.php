<?php

namespace App\Controllers;

use App\Models\UsersModel;

class Auth extends BaseController
{

    protected $usersModel;

    public function __construct()
    {
        $this->usersModel = new UsersModel();
    }

    public function index()
    {

        //Cek Apakah Ada Session
        if (session()->get('logged_in')) {
            if (session()->get('role_id') == 1) {
                return redirect()->to(base_url('admin'));
            } else if (session()->get('role_id') == 2) {
                return redirect()->to(base_url('pelayan'));
            } else if (session()->get('role_id') == 3) {
                return redirect()->to(base_url('koki'));
            } else if (session()->get('role_id') == 4) {
                return redirect()->to(base_url('kasir'));
            } else if (session()->get('role_id') == 5) {
                return redirect()->to(base_url('koki'));
            }
        }
        $data = [
            'title' => 'MieAceh Titi Bobrok || Login',
            'validation' => \Config\Services::validation()
        ];
        return view('auth/login', $data);
    }

    public function loginSave()
    {

        //Validasi Form Terlebih Dahulu
        if (!$this->validate([
            //Field Yang mau divalidasi
            'email' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Wajib Diisi ! '
                ]
            ],
            'password' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Wajib Diisi ! '
                ]
            ]
        ])) {
            //Kalau tidak tervalidasi
            return redirect()->to(base_url())->withInput();
        }

        //Ambil Data Form
        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');

        //Cek Data Login
        $user = $this->usersModel->where(['email' => $email])->first();

        //Validasi Loginnya
        if ($user) {
            //Jika Ada Usernya
            //1.Cek Apakah Passwordnya Benar
            if ($user['password'] == password_verify($password, $user['password'])) {
                //Kalau Benar Cek Usernya Aktif Gak
                if ($user['is_active'] == 1) {
                    //Kalau Aktif Kasi Session
                    //1.Simpan session usernya
                    $dataSession = [
                        'nama' => $user['nama'],
                        'email' => $user['email'],
                        'role_id' => $user['role_id'],
                        'foto' => $user['foto'],
                        'logged_in' => TRUE
                    ];
                    session()->set($dataSession);

                    //2. Redirect Ke Halaman Masing Masing
                    if ($user['role_id'] == 1) {
                        return redirect()->to(base_url('admin'));
                    } else if ($user['role_id'] == 2) {
                        return redirect()->to(base_url('penjualan/inputPenjualan'));
                    } else if ($user['role_id'] == 3 or $user['role_id'] == 5) {
                        return redirect()->to(base_url('dapur'));
                    } else if ($user['role_id'] == 4) {
                        return redirect()->to(base_url('kasir/pembayaran'));
                    }
                } else {
                    //litertly wicis if user tidak aktif
                    session()->setFlashdata('login', 'Akun anda Belum Aktif, harap hubungi admin ! ');
                    return redirect()->to(base_url());
                }
            } else {
                session()->setFlashdata('login', 'Password Salah ! ');
                return redirect()->to(base_url());
            }
        } else {
            //Jika Tidak
            session()->setFlashdata('login', 'Email Belum Terdaftar ! ');
            return redirect()->to(base_url());
        }
    }

    public function logout()
    {
        //Hancurkan Session
        $dataSession = [
            'nama',
            'email',
            'role_id',
            'foto',
            'logged_in'
        ];
        session()->remove($dataSession);
        return redirect()->to(base_url());
    }

    public function register()
    {
        $password = 'aqilmustaqim16';

        if ($this->usersModel->save([
            'nama' => 'Aqil Mustaqim',
            'email' => 'aqilmustaqim28@gmail.com',
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'role_id' => 1,
            'foto' => 'default.png',
            'is_active' => 1
        ])) {
            echo 'berhasil';
        }
    }
}
