<?= $this->extend('partials/index'); ?>
<?= $this->section('content'); ?>

<!--**********************************
            Content body start
        ***********************************-->
<div class="content-body">
    <div class="container-fluid">

        <!-- row -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Data Penjualan</h4>
                        <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#modalDataPenjualan">Cetak Data Penjualan</button>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example" class="display" style="min-width: 845px">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Invoice</th>
                                        <th>Waiters</th>
                                        <th>Pelanggan</th>
                                        <th>Tanggal</th>
                                        <th>Total</th>
                                        <th>Tipe</th>
                                        <th>Pesanan</th>
                                        <th>Status</th>
                                        <th>Aksi</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $nomor = 1; ?>
                                    <?php foreach ($dataPenjualan as $dp) : ?>
                                        <tr>
                                            <td>
                                                <button class="badge badge-grey"><?= $nomor++; ?></button>

                                            </td>
                                            <td><?= $dp['invoice']; ?></td>
                                            <td>
                                                <button class="badge badge-info"><?= $dp['waiters']; ?></button>

                                            </td>
                                            <td><b><?= $dp['pelanggan']; ?></b></td>
                                            <td><?= $dp['tanggal']; ?></td>
                                            <td>
                                                <button class="badge badge-black"><?= number_format($dp['total']); ?></button>

                                            </td>

                                            <td>
                                                <?php if ($dp['tipe_pesanan'] == 1) {
                                                    echo 'Dine In';
                                                } else {
                                                    echo 'Take Away';
                                                } ?>
                                            </td>
                                            <td>
                                                <?php if ($dp['status_pesanan'] == 0) {
                                                    echo '<button class="badge badge-danger">Proses</button>';
                                                } else {
                                                    echo '<button class="badge badge-success">Selesai</button>';
                                                } ?>
                                            </td>
                                            <td>
                                                <?php if ($dp['status_pembayaran'] == 0) {
                                                    echo 'Belum Bayar';
                                                } else {
                                                    echo 'Sudah Bayar';
                                                } ?>
                                            </td>

                                            <td>

                                                <button type="button" class="badge badge-primary" data-toggle="modal" data-target="#DetailPenjualan<?= $dp['id']; ?>">++</button>
                                                <a href="<?= base_url(); ?>/penjualan/hapusPenjualan/<?= $dp['id']; ?>" class="badge badge-danger tombol-hapus"><i class="fa fas fa-trash"></i></i></a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>

                            </table>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
<!--**********************************
            Content body end
***********************************-->

<?php foreach ($dataPenjualan as $p) : ?>
    <div class="modal fade" id="DetailPenjualan<?= $p['id']; ?>">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Detail Pesanan Invoice : <?= $p['invoice']; ?></h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <i class="anticon anticon-close"></i>
                    </button>
                </div>
                <?php $detailPesanan = cek_detail_pesanan($p['invoice']); ?>
                <table class="table table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>No</th>
                            <th>Pesanan</th>
                            <th>Jumlah</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <?php $no = 1; ?>
                    <?php foreach ($detailPesanan as $dp) : ?>
                        <tbody>
                            <!-- Perulangan Data Menu Psanan -->
                            <td><button class="badge badge-black"><?= $no++; ?></button></td>
                            <td><b><?= $dp['nama_produk']; ?></b></td>
                            <td><?= $dp['jumlah']; ?></td>
                            <td>
                                <?php if ($dp['status_menu'] == 0) { ?>
                                    <button class="badge badge-primary" data-id="<?= $dp['id']; ?>">Proses</button>
                                <?php } else { ?>
                                    <button class="badge badge-success">Selesai</button>
                                <?php } ?>
                            </td>
                        </tbody>
                    <?php endforeach; ?>
                </table>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<!-- Modal Cetak Data Penjualan -->
<div class="modal fade" id="modalDataPenjualan">
    <div class="modal-dialog">
        <form action="<?= base_url('penjualan/laporanPenjualan'); ?>" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Cetak Data Penjualan</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <i class="anticon anticon-close"></i>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Pilih Tanggal Awal</label>
                            <input type="date" id="tanggal_awal" name="tanggal_awal" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Pilih Tanggal Akhir</label>
                            <input type="date" id="tanggal_akhir" name="tanggal_akhir" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Cetak Data</button>
                    <!-- tombol-cetak-penjualan -->
                </div>
        </form>
    </div>
</div>
</div>


<script>
    $(document).ready(function() {
        $('#main-wrapper').addClass('menu-toggle');
        $('.hamburger').addClass('is-active');
    })
</script>



<?= $this->endSection(); ?>