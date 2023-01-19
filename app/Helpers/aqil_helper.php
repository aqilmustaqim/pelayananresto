<?php
function cek_detail_pesanan($invoice)
{
    $db      = \Config\Database::connect();
    $builder = $db->table('penjualan_detail');
    $builder->select('nama_produk,jumlah,penjualan_detail.id,status_menu');
    $builder->join('produk', 'penjualan_detail.id_produk = produk.id');
    $builder->join('penjualan', 'penjualan_detail.invoice = penjualan.invoice');
    $builder->where('penjualan_detail.invoice', $invoice);
    $query = $builder->get();
    $detailPesanan = $query->getResultArray();
    return $detailPesanan;
}
