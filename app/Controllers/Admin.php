<?php

namespace App\Controllers;

use App\Models\UsersModel;

class Admin extends BaseController
{

    protected $usersModel;

    public function __construct()
    {
        $this->usersModel = new UsersModel();
    }



    public function index()
    {
        //Menghitung Jumlah User
        $db      = \Config\Database::connect();
        $builder = $db->table('users');
        $builder->selectCount('id');
        $hasil = $builder->get();
        $jumlahUsers = $hasil->getRowArray();
        $users = $jumlahUsers['id'];

        //Menghitung Jumlah Produk
        $db      = \Config\Database::connect();
        $builder = $db->table('produk');
        $builder->selectCount('id');
        $query = $builder->get();
        $jumlahProduk = $query->getRowArray();
        $produk = $jumlahProduk['id'];

        //Menghitung Jumlah Kategori
        $db      = \Config\Database::connect();
        $builder = $db->table('kategori_produk');
        $builder->selectCount('id');
        $query = $builder->get();
        $jumlahKategori = $query->getRowArray();
        $kategori = $jumlahKategori['id'];

        //Menghitung Jumlah Penjualan
        $db      = \Config\Database::connect();
        $builder = $db->table('penjualan');
        $builder->selectCount('id');
        $query = $builder->get();
        $jumlahPenjualan = $query->getRowArray();
        $penjualan = $jumlahPenjualan['id'];

        //Menghitung Total Penjualan Hari Ini
        //Jalankan Query SUM untuk jumlah total penjualan
        $db      = \Config\Database::connect();
        $builder = $db->table('penjualan');
        $builder->select('SUM(total) as totalpenjualan');
        $builder->where('tanggal', date('Y-m-d'));
        $query = $builder->get();
        $hasilpenjualan = $query->getRowArray();
        if ($hasilpenjualan) {
            $penjualanhariini = $hasilpenjualan['totalpenjualan'];
        } else {
            $penjualanhariini = 0;
        }

        //Menghitung Total Penjualan Bulan Ini
        //Jalankan Query SUM untuk jumlah total penjualan
        $db      = \Config\Database::connect();
        $builder = $db->table('penjualan');
        $builder->select('SUM(total) as totalpenjualan');
        $builder->like('tanggal', date('m'));
        $query = $builder->get();
        $hasilpenjualan = $query->getRowArray();
        if ($hasilpenjualan) {
            $penjualanBulanIni = $hasilpenjualan['totalpenjualan'];
        } else {
            $penjualanBulanIni = 0;
        }

        //Menghitung Total Penjualan Tahun Ini
        //Jalankan Query SUM untuk jumlah total penjualan
        $db      = \Config\Database::connect();
        $builder = $db->table('penjualan');
        $builder->select('SUM(total) as totalpenjualan');
        $builder->like('tanggal', date('Y'));
        $query = $builder->get();
        $hasilpenjualan = $query->getRowArray();
        if ($hasilpenjualan) {
            $penjualanTahunIni = $hasilpenjualan['totalpenjualan'];
        } else {
            $penjualanTahunIni = 0;
        }


        //Mengambil Data Penjualan Hari Ini
        $db      = \Config\Database::connect();
        $builder = $db->table('penjualan');
        $builder->select('*');
        $builder->where('tanggal', date('Y-m-d'));
        $query = $builder->get();
        $dataPenjualan = $query->getResultArray();

        //Menghitung Jumlah Produk Paling Banyak Terjual
        $db      = \Config\Database::connect();
        $builder = $db->table('penjualan_detail');
        $builder->select('penjualan_detail.id_produk,foto_produk,harga_produk,nama_produk,SUM(jumlah) as jumlah_terjual');
        $builder->selectCount('penjualan_detail.id_produk');
        $builder->join('produk', 'penjualan_detail.id_produk = produk.id');
        $builder->orderBy('jumlah_terjual', 'DESC');
        $builder->groupBy('penjualan_detail.id_produk');
        $builder->limit(5);
        $query = $builder->get();
        $produkterbanyak = $query->getResultArray();


        $data = [
            'title' => 'RestoServe || Dashboard Admin',
            'validation' => \Config\Services::validation(),
            'users' => $users,
            'produk' => $produk,
            'kategori' => $kategori,
            'penjualan' => $penjualan,
            'penjualanbulanan' => $penjualanBulanIni,
            'penjualantahunan' => $penjualanTahunIni,
            'penjualanharian' => $penjualanhariini,
            'datapenjualan' => $dataPenjualan,
            'produkterbanyak' => $produkterbanyak
        ];
        return view('admin/index', $data);
    }
}
