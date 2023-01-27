<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use \App\Models\TempPenjualanModel;
use \App\Models\ProdukModel;
use \App\Models\PenjualanModel;
use \App\Models\PenjualanDetailModel;
use \App\Models\MejaModel;


class Kasir extends BaseController
{

    protected $produkModel;
    protected $penjualanModel;
    protected $penjualanDetailModel;
    protected $mejaModel;

    public function __construct()
    {
        //Masukkan Users Model Ke Dalam Variabel
        $this->produkModel = new ProdukModel();
        $this->penjualanModel = new PenjualanModel();
        $this->penjualanDetailModel = new PenjualanDetailModel();
        $this->mejaModel = new MejaModel();
    }

    public function index()
    {
        $data = [
            'title' => 'RestoServe || Dashboard Kasir',
            'validation' => \Config\Services::validation()
        ];
        return view('kasir/index', $data);
    }

    public function pembayaran()
    {
        //cek status login
        if (!session()->has('logged_in')) {
            session()->setFlashdata('login', 'Silahkan Login Terlebih Dahulu !');
            return redirect()->to(base_url());
        } else {
            if (session()->get('role_id') == 2) {
                return redirect()->to(base_url('pelayan'));
            } else if (session()->get('role_id') == 3) {
                return redirect()->to(base_url('koki'));
            } else if (session()->get('role_id') == 5) {
                return redirect()->to(base_url('koki'));
            }
        }

        $db = \Config\Database::connect();
        $builder = $db->table('penjualan');
        $builder->select('penjualan.id,invoice,pelanggan,tanggal,nomor_meja,tipe_pesanan,total');
        $builder->join('meja', 'penjualan.id_meja = meja.id');
        $builder->where('status_pesanan', 1);
        $builder->where('status_pembayaran', 0);
        $query = $builder->get();
        $penjualan = $query->getResultArray();

        $data = [
            'title' => 'RestoServe || Data Pembayaran',
            'penjualan' => $penjualan
        ];

        return view('kasir/pembayaran', $data);
    }

    public function datapembayaran()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('penjualan');
        $builder->select('penjualan.id,invoice,pelanggan,tanggal,nomor_meja,tipe_pesanan,total');
        $builder->join('meja', 'penjualan.id_meja = meja.id');
        $builder->where('status_pesanan', 1);
        $builder->where('status_pembayaran', 0);
        $query = $builder->get();
        $penjualan = $query->getResultArray();
        echo json_encode($penjualan);
    }
}
