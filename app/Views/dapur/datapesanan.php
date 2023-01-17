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
                        <h4 class="card-title">Data Pesanan</h4>
                        <div class="produk" data-produk="<?= session()->getFlashdata('produk'); ?>"></div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example" class="display" style="min-width: 845px">
                                <thead>
                                    <tr>
                                        <th>Invoice</th>
                                        <th>Pelanggan</th>
                                        <th>Tanggal</th>
                                        <th>Nomor Meja</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php foreach ($penjualan as $p) : ?>
                                        <tr>
                                            <td>
                                                <img class="img img-thumbnail" src="<?= base_url('assets'); ?>/images/product/<?= $p['foto_produk']; ?>" width="100px" alt="">
                                            </td>
                                            <td><?= $p['invoice']; ?></td>
                                            <td><?= $p['pelanggan']; ?></td>
                                            <td><?= $p['tanggal']; ?></td>
                                            <td><?= $p['nomor_meja']; ?></td>

                                            <td>
                                                <?= ($p['stok_produk'] == 1 ? '<button class="badge badge-success">Tersedia</button>' : '<button class="badge badge-danger">Tidak Tersedia</button>') ?>
                                            </td>
                                            <td>
                                                <a href="<?= base_url(); ?>/master/editProduk/<?= $p['id']; ?>" class="badge badge-info"><i class="fa fas fa-edit"></i></a>
                                                <a href="<?= base_url(); ?>/master/hapusProduk/<?= $p['id']; ?>" class="badge badge-danger tombol-hapus"><i class="fa fas fa-trash"></i></i></a>

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

<script>
    $(document).ready(function() {
        $('#main-wrapper').addClass('menu-toggle');
    })
</script>
<?= $this->endSection(); ?>