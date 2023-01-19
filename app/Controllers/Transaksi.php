<?php

namespace App\Controllers;

use App\Database\Migrations\UserRole;
use \App\Models\UsersModel; // Memanggil User Model Dari Class Model
use \App\Models\UserRoleModel;
use \App\Models\TempPenjualanModel;
use \App\Models\ProdukModel;
use \App\Models\PenjualanModel;
use \App\Models\PenjualanDetailModel;
use \App\Models\MejaModel;

class Transaksi extends BaseController
{

    //Membuat Variabel Untuk Menampung UsersModel
    protected $usersModel; //Membuat Variabel Untuk Menampung UsersModel
    protected $userRole;
    protected $tempPenjualanModel;
    protected $produkModel;
    protected $penjualanModel;
    protected $penjualanDetailModel;
    protected $mejaModel;

    public function __construct()
    {
        //Masukkan Users Model Ke Dalam Variabel
        $this->usersModel = new UsersModel();
        $this->userRole = new UserRoleModel();
        $this->tempPenjualanModel = new TempPenjualanModel();
        $this->produkModel = new ProdukModel();
        $this->penjualanModel = new PenjualanModel();
        $this->penjualanDetailModel = new PenjualanDetailModel();
        $this->mejaModel = new MejaModel();
    }

    public function index()
    {
        //cek status login
        if (!session()->has('logged_in')) {
            session()->setFlashdata('login', 'Silahkan Login Terlebih Dahulu !');
            return redirect()->to(base_url());
        } else {
            if (session()->get('role_id') == 2) {
                return redirect()->to(base_url('pelayan'));
            } else if (session()->get('role_id') == 4) {
                return redirect()->to(base_url('kasir'));
            }
        }

        //Cek Session Login
        if (session()->get('role_id') == 3) {
            $db = \Config\Database::connect();
            $builder = $db->table('penjualan');
            $builder->select('penjualan.id,invoice,pelanggan,tanggal,nomor_meja,tipe_pesanan');
            $builder->join('meja', 'penjualan.id_meja = meja.id');
            $builder->where('tipe_pesanan', 1);
            $query = $builder->get();
            $penjualan = $query->getResultArray();
        } else  if (session()->get('role_id') == 5) {
            $db = \Config\Database::connect();
            $builder = $db->table('penjualan');
            $builder->select('penjualan.id,invoice,pelanggan,tanggal,nomor_meja,tipe_pesanan');
            $builder->join('meja', 'penjualan.id_meja = meja.id');
            $builder->where('tipe_pesanan', 2);
            $query = $builder->get();
            $penjualan = $query->getResultArray();
        } else {
            $db = \Config\Database::connect();
            $builder = $db->table('penjualan');
            $builder->select('penjualan.id,invoice,pelanggan,tanggal,nomor_meja,tipe_pesanan');
            $builder->join('meja', 'penjualan.id_meja = meja.id');
            $query = $builder->get();
            $penjualan = $query->getResultArray();
        }

        $data = [
            'title' => 'RestoServe || Transaksi Pemesanan'
        ];

        return view('transaksi/transaksipemesanan', $data);
    }
}
