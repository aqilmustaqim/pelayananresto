<?= $this->extend('partials/index'); ?>
<?= $this->section('content'); ?>

<!--**********************************
            Content body start
***********************************-->
<div class="content-body">
    <div class="container-fluid">

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Transaksi Penjualan</h4>
                        <div class="produk" data-produk="<?= session()->getFlashdata('produk'); ?>"></div>

                    </div>
                    <div class="card-header">
                        <div class="form-row">
                            <div class="form-group col-lg-3">
                                <label for="" style="font-weight: bold;">Waiters</label>
                                <input type="text" id="waiters" name="waiters" class="form-control input-rounded" style="border: 1px solid #000000;" value="<?= session()->get('nama'); ?>" readonly>
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="" style="font-weight: bold;">No Invoice</label>
                                <input type="text" id="invoice" name="invoice" class="form-control input-rounded" style="border: 1px solid #000000;" id="invoice" value="<?= $invoice; ?>" readonly>
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="" style="font-weight: bold;">Tanggal</label>
                                <input type="date" id="tanggal" name="tanggal" class="form-control input-rounded tanggal" style="border: 1px solid #000000;" id="tanggal" value="<?= date('Y-m-d'); ?>" readonly>
                            </div>
                            <div class="form-group input-primary col-lg-3">
                                <label for="" style="font-weight: bold;">Pelanggan</label>
                                <input type="text" id="nama_pelanggan" name="nama_pelanggan" class="form-control input-rounded" placeholder="Nama Pelanggan...">
                            </div>

                        </div>

                    </div>
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-7 order-md-2 mb-4">
                                <div class="dataDetailPenjualan">

                                </div>

                                <div class="form-row">
                                    <div class="form-group col-lg-6">
                                        <label for="inputState" style="font-weight: bold;">Total Bayar</label>
                                        <div class="input-group flex-nowrap">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="addon-wrapping">Rp.</span>
                                            </div>
                                            <input type="text" name="total_bayar" id="total_bayar" class="form-control input-rounded" style="font-weight: bold; text-align: right; color: darkgreen; font-size: 20pt;" placeholder="0" aria-describedby="addon-wrapping" readonly>
                                        </div>
                                    </div>

                                    <div class="form-group col-lg-6">

                                        <button class="btn btn-primary" type="submit" id="simpanPenjualan"><i class="fa fa-save"></i></button>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-5 order-md-1">

                                <div class="form-row">

                                    <div class="form-group input-primary col-lg-6">
                                        <label for="" style="font-weight: bold;">Kode Produk</label>
                                        <input type="text" name="kode_produk" class="form-control input-rounded" placeholder="Tekan Enter..." id="kodeproduk" autofocus>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="" style="font-weight: bold;">Nama Produk</label>
                                        <input type="text" name="nama_produk" class="form-control input-rounded" style="border: 1px solid #000000;" id="namaproduk" readonly>
                                    </div>



                                </div>
                                <div class="form-row">

                                    <div class="form-group input-primary col-lg-6">
                                        <label for="inputState" style="font-weight: bold;">Jumlah</label>
                                        <input type="number" name="jumlah_produk" class="form-control input-rounded" id="jumlah" placeholder="Masukkan Jumlah...">
                                    </div>
                                </div>


                                <button class="btn btn-primary btn-lg btn-block tombolTambahKeranjang">Tambahkan</button>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modalProduk" style="display: none;">

        </div>
        <div class="modalPembayaran" style="display: none;">

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

        dataDetailPenjualan();

        $('#kodeproduk').keydown(function(e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                cekKodeProduk();
            }
        });
    })


    function dataDetailPenjualan() {
        $.ajax({
            type: "post",
            url: "<?= base_url(); ?>/penjualan/detailPenjualan",
            data: {
                invoice: $('#invoice').val()
            },
            dataType: "json",
            beforeSend: function() {
                $('.dataDetailPenjualan').html('<i class= "fa fa-spin fa-spinner"></i>')
            },
            success: function(response) {
                $('.dataDetailPenjualan').html(response.data);
            },
            error: function(xhr, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }

    function cekKodeProduk() {
        //Tangkap Value dari inputan Kode Produk
        let kodeProduk = $('#kodeproduk').val();
        let namaproduk = $('#namaproduk').val();
        //Jalankan Ajax
        if (kodeProduk == '') {
            //Ketika Kosong Maka Akan Tampilkan Modal Yang Isinya Produk
            $.ajax({
                url: "<?= base_url(); ?>/penjualan/dataProduk",
                dataType: "json",
                success: function(response) {
                    //Kalau Berhasil Maka Tampilkan Modalnya
                    $('.modalProduk').html(response.viewmodal).show();

                    $('#modalproduk').modal('show');
                }
            });
        } else {
            $.ajax({
                type: "post",
                url: "<?= base_url(); ?>/penjualan/dataProduk2",
                data: {
                    kodeproduk: kodeProduk,
                    namaproduk: namaproduk
                },
                dataType: "json",
                success: function(response) {
                    //Kalau Berhasil Maka Tampilkan Modalnya
                    $('.modalProduk').html(response.viewmodal).show();

                    $('#modalproduk').modal('show');

                }
            });
        }
    }
</script>

<?= $this->endSection(); ?>