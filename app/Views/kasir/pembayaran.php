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
                        <h4 class="card-title">Data Pembayaran</h4>

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
                                        <th>Tipe Pesanan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="baris-pesanan-pembayaran">


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
        selesai();
    })

    function selesai() {
        setTimeout(function() {
            update();
            selesai();
        }, 1000);
    }

    function update() {
        $.getJSON('<?= base_url('kasir/datapembayaran'); ?>', function(data) {
            $('#baris-pesanan-pembayaran').empty();
            $.each(data, function(i, data) {
                $('#baris-pesanan-pembayaran').append(
                    `
                        <tr>
                        <td> <button class="badge badge-pill badge-secondary"> ${data.invoice} </button></td>
                        <td><b>  ${data.pelanggan} </b></td>
                        <td>  <button class="badge badge-pill badge-black"> ${data.tanggal}</button> </td>
                        <td>  ${data.nomor_meja == 0 ? `<button class="badge badge-pill badge-danger">Tidak ada</button>` : `<button class="badge badge-pill badge-info">${data.nomor_meja}</button>`} </td>
                        <td>  ${data.tipe_pesanan == 1 ? `<button class="badge badge-pill badge-success">Dine In</button>` : `<button class="badge badge-pill badge-black">Take Away</button>`} </td>
                        <td>
                        <button class="btn btn-sm light btn-primary" data-toggle="modal" data-target="#DetailPembayaran${data.id}">Bayar</button>
                        </td>
                        </tr>'
                        `
                )
            });
        });

    }
</script>
<?php foreach ($penjualan as $p) : ?>
    <div class="modal fade" id="DetailPembayaran<?= $p['id']; ?>">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Detail Pesanan Invoice : <?= $p['invoice']; ?></h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <i class="anticon anticon-close"></i>
                    </button>
                </div>
                <?php $detailPesanan = cek_detail_pesanan($p['invoice']); ?>
                <table class="table table-bordered table-stripped">
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
                                    <button class="btn btn-sm light btn-primary prosesMenuPesanan" data-id="<?= $dp['id']; ?>">Proses</button>
                                <?php } else { ?>
                                    <button class="btn btn-sm light btn-success">Selesai</button>
                                <?php } ?>
                            </td>
                        </tbody>
                    <?php endforeach; ?>
                </table>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <?php if ($dp['status_menu'] == 1) : ?>
                        <a href="#" class="btn btn-primary" data-id="<?= $p['id']; ?>">Proses Bayar</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<?= $this->endSection(); ?>