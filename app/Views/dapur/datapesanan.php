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
                        <h4 class="card-title">Data Pesanan Dapur</h4>
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
                                <tbody id="baris-pesanan">


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
        }, 5000);
    }

    function update() {
        $.getJSON('<?= base_url('dapur/datapesanan'); ?>', function(data) {
            $('#baris-pesanan').empty();
            $.each(data, function(i, data) {
                $('#baris-pesanan').append(
                    `
                        <tr>
                        <td> <button class="badge badge-pill badge-secondary"> ${data.invoice} </button></td>
                        <td><b>  ${data.pelanggan} </b></td>
                        <td>  <button class="badge badge-pill badge-black"> ${data.tanggal}</button> </td>
                        <td>  ${data.nomor_meja == 0 ? `<button class="badge badge-pill badge-danger">Tidak ada</button>` : `<button class="badge badge-pill badge-info">${data.nomor_meja}</button>`} </td>
                        
                        <td>
                        <button class="btn btn-success light me-2" data-toggle="modal" data-target="#DetailMenuModal${data.id}">
													<svg xmlns="http://www.w3.org/2000/svg" class="svg-main-icon" width="24px" height="24px" viewBox="0 0 32 32" x="0px" y="0px"><g data-name="Layer 21"><path d="M29,14.47A15,15,0,0,0,3,14.47a3.07,3.07,0,0,0,0,3.06,15,15,0,0,0,26,0A3.07,3.07,0,0,0,29,14.47ZM16,21a5,5,0,1,1,5-5A5,5,0,0,1,16,21Z" fill="#000000" fill-rule="nonzero"></path><circle cx="16" cy="16" r="3" fill="#000000" fill-rule="nonzero"></circle></g></svg>
												</button>
                        </td>
                        </tr>'
                        `
                )
            });
        });

    }
</script>
<?php foreach ($penjualan as $p) : ?>
    <div class="modal fade" id="DetailMenuModal<?= $p['id']; ?>">
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
                        <a href="#" class="btn btn-primary prosesPesananReady" data-id="<?= $p['id']; ?>">Pesanan Ready</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<script>
    $('.prosesMenuPesanan').on('click', function() {
        //Ambil Nilai Dari Id dari pesanan_menu
        const idMenu = $(this).data('id');
        //Mulai Ajax
        Swal.fire({
            title: 'Apakah Anda Yakin?',
            html: `Menu Pesanan Akan Di Proses`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Iya, Proses !'
        }).then((result) => {
            if (result.isConfirmed) {
                //Jalankan Ajax
                $.ajax({
                    url: '<?= base_url('dapur/prosesPesanan'); ?>',
                    method: 'post',
                    data: {
                        idMenu: idMenu
                    },
                    success: function(data) {
                        if (data == "berhasil") {
                            Swal.fire({
                                title: 'Proses Menu Pesanan',
                                text: 'Berhasil Di Proses',
                                icon: 'success'
                            }).then((result) => {
                                document.location.reload();
                            })
                        }
                    }
                });
            }
        })
    });

    $('.prosesPesananReady').on('click', function() {
        //Tampung id di varibel
        const idPenjualan = $(this).data('id');
        //Mulai Fungsi Ajax
        Swal.fire({
            title: 'Apakah Anda Yakin?',
            html: `Pesanan Sudah Selesai`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Iya, Proses !'
        }).then((result) => {
            if (result.isConfirmed) {
                //Jalankan Ajax
                $.ajax({
                    url: '<?= base_url('dapur/prosesPesananReady'); ?>',
                    method: 'post',
                    data: {
                        idPenjualan: idPenjualan
                    },
                    success: function(data) {
                        if (data == "berhasil") {
                            Swal.fire({
                                title: 'Proses Menu Pesanan',
                                text: 'Berhasil Di Selesaikan',
                                icon: 'success'
                            }).then((result) => {
                                document.location.reload();
                            })
                        }
                    }
                });
            }
        })

    });
</script>
<?= $this->endSection(); ?>