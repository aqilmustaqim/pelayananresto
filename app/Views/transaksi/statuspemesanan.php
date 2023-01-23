<?= $this->extend('partials/index'); ?>
<?= $this->section('content'); ?>

<!--**********************************
            Content body start
        ***********************************-->
<div class="content-body">

    <!-- row -->
    <div class="container-fluid bg-gray">


        <div class="row order-row" id="dataStatusPemesanan">

        </div>


    </div>

</div>
<!--**********************************
            Content body end
***********************************-->



<script>
    $(document).ready(function() {
        $('#main-wrapper').addClass('menu-toggle');
        $('.hamburger').addClass('is-active');
        selesai();
    })

    function selesai() {
        setTimeout(function() {
            update();
            selesai();
        }, 200);
    }

    function update() {
        $.getJSON('<?= base_url('transaksi/statusPemesanan'); ?>', function(data) {
            $('#dataStatusPemesanan').empty();
            $.each(data, function(i, data) {
                $('#dataStatusPemesanan').append(
                    `
                        <div class="col-sm-3">
                            <div class="card-container">
                                <div class="card shadow-sm">
                                    <div class="card-header ${data.tipe_pesanan == 1 ? `bg-secondary` : `bg-info`} text-white">
                                        <div>
                                            <h4 class="text-white">${data.tipe_pesanan == 1 ? `Dine In` : `Take Away`}</h4>
                                            <span class="fs-12 op9">${data.invoice}</span>
                                        </div>
                                        <div>

                                            <h3 class="text-white" style="font-size: 13pt;"> Meja : ${data.nomor_meja == 0 ? `--` : `${data.nomor_meja}`} </h3>
                                            <button class="badge ${data.status_pesanan == 1 ? `bg-success` : `bg-danger`} "><span class="fs-12 op9">${data.status_pesanan == 1 ? `Ready` : `Process`}</span></button>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                    <h3 style="font-size: 11pt;">Pelanggan :  <button class="badge badge-black"><span class="fs-12 op9">${data.pelanggan}</span></button></h3> 
                                        
                                    </div>

                                </div>
                            </div>
                        </div>
                    `
                )
            });
        });

    }

    function update2() {
        $('#dataStatusPemesanan').empty();
        <?php foreach ($penjualan as $p) :  ?>
            $('#dataStatusPemesanan').append(
                `
                        <div class="col-sm-3">
                            <div class="card-container">
                                <div class="card shadow-sm">
                                    <div class="card-header <?= ($p['tipe_pesanan'] == 1 ? 'bg-secondary' : 'bg-info'); ?> text-white">
                                        <div>
                                            <h4 class="text-white"><?= ($p['tipe_pesanan'] == 1 ? 'Dine In' : 'Take Away'); ?></h4>
                                            <span class="fs-12 op9"><?= $p['invoice']; ?></span>
                                        </div>
                                        <div>

                                            <h3 class="text-white" style="font-size: 13pt;"> Meja : <?= ($p['nomor_meja'] == 0 ? '--' : $p['nomor_meja']); ?> </h3>
                                            <button class="badge <?= ($p['status_pesanan'] == 1 ? 'bg-success' : 'bg-danger'); ?> "><span class="fs-12 op9"><?= ($p['status_pesanan'] == 1 ? 'Ready' : 'Process'); ?></span></button>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <?php $detailpesanan = cek_detail_pesanan($p['invoice']) ?>
                                        <?php foreach ($detailpesanan as $dp) : ?>
                                            <ul class="order-list">
                                                <li>
                                                    <?php if ($dp['status_menu'] == 1) { ?>
                                                        <del>
                                                            <b><span><?= $dp['jumlah']; ?> </span> <?= $dp['nama_produk']; ?></b>
                                                        </del>
                                                    <?php } else { ?>
                                                        <b><span><?= $dp['jumlah']; ?> </span> <?= $dp['nama_produk']; ?></b>
                                                    <?php } ?>
                                                </li><br>

                                            </ul>
                                        <?php endforeach; ?>
                                        <hr>
                                        <button class="badge badge-black"><span class="fs-12 op9"><?= $p['pelanggan']; ?></span></button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    `
            )
        <?php endforeach; ?>

    }
</script>



<?= $this->endSection(); ?>