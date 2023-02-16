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
                                <!-- <tbody id="baris-pesanan-pembayaran"> -->

                                <tbody>
                                    <?php foreach ($penjualan as $p) : ?>
                                        <tr>
                                            <td> <button class="badge badge-pill badge-secondary"> <?= $p['invoice']; ?> </button></td>
                                            <td><b> <?= $p['pelanggan']; ?> </b></td>
                                            <td> <button class="badge badge-pill badge-black"> <?= $p['tanggal']; ?></button> </td>
                                            <td>
                                                <?php if ($p['nomor_meja'] == 0) { ?>
                                                    <button class="badge badge-pill badge-danger">Tidak ada</button>
                                                <?php } else { ?>
                                                    <button class="badge badge-pill badge-info"><?= $p['nomor_meja']; ?></button>
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <?php if ($p['tipe_pesanan'] == 1) { ?>
                                                    <button class="badge badge-pill badge-success">Dine In</button>
                                                <?php } else { ?>
                                                    <button class="badge badge-pill badge-black">Take Away</button>
                                                <?php } ?>


                                            </td>
                                            <td>
                                                <button class="badge badge-sm light badge-danger" data-toggle="modal" data-target="#DetailPembayaran<?= $p['id']; ?>">Detail</button>
                                                <button class="btn btn-sm light btn-primary" data-toggle="modal" data-target="#ModalPembayaran<?= $p['id']; ?>">Bayar</button>
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

                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<?php foreach ($penjualan as $p) : ?>
    <div class="modal fade" id="ModalPembayaran<?= $p['id']; ?>">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Pembayaran Invoice : <?= $p['invoice']; ?></h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <i class="anticon anticon-close"></i>
                    </button>
                </div>
                <!-- Tampilkan Form Pembayaran -->
                <form action="<?= base_url('penjualan/simpanPembayaran'); ?>" class="formPembayaran">
                    <div class="modal-body">
                        <div class="form-row">

                            <input type="hidden" name="id" id="" value="<?= $p['id']; ?>">
                            <input type="hidden" name="idmeja" id="" value="<?= $p['id_meja']; ?>">
                            <input type="hidden" id="strukkasir" name="kasir" value="<?= session()->get('nama'); ?>">
                            <input type="hidden" id="strukinvoice" name="invoice" value="<?= $p['invoice']; ?>">
                            <input type="hidden" id="strukpelanggan" name="pelanggan" value="<?= $p['pelanggan']; ?>">

                            <div class="form-group col-md-12">
                                <label>Total Pembayaran</label>
                                <input type="text" id="total_pembayaran" name="total_pembayaran" class="form-control total_pembayaran" style="font-weight: bold; text-align: right; color: seagreen; font-size: 20pt;" value="<?= $p['total']; ?>" readonly>

                            </div>
                            <div class="form-group col-md-6">
                                <label>Jumlah Uang</label>
                                <input type="text" id="jumlah_uang" name="jumlah_uang" class="form-control jumlah_uang" style="font-weight: bold; text-align: right; color: red; font-size: 20pt;" autocomplete="off">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Sisa Uang</label>
                                <input type="text" id="sisa_uang" name="sisa_uang" class="form-control sisa_uang" style="font-weight: bold; text-align: right; color: blue; font-size: 20pt;" readonly>
                            </div>




                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success tombolBayar">Bayar</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>


            </div>
        </div>
    </div>

<?php endforeach; ?>

<script>
    $(document).ready(function() {
        $('#main-wrapper').addClass('menu-toggle');
        $('.hamburger').addClass('is-active');

        // $('.prosesPembayaran').click(function(e) {
        //     e.preventDefault();
        //     prosesPembayaran();
        // });



        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        $('.jumlah_uang').autoNumeric('init', {
            aSep: ',',
            aDec: '.',
            mDec: '0'
        });
        $('.sisa_uang').autoNumeric('init', {
            aSep: ',',
            aDec: '.',
            mDec: '0'
        });
        $('.total_pembayaran').autoNumeric('init', {
            aSep: ',',
            aDec: '.',
            mDec: '0'
        });


        //Ketika Jumlah Uang Di Ketik Maka Sisa Uang Akan Muncul
        $('.jumlah_uang').keyup(function() {
            //Ambil Inputan Jumlah Uangnya dan total pembayaran
            let totalPembayaran = $('.total_pembayaran').autoNumeric('get');
            let jumlahUang = ($('.jumlah_uang').val() == "") ? 0 : $('.jumlah_uang').autoNumeric('get');
            //Jumlah Uang - Total Pembayaran
            let sisaUang = parseFloat(jumlahUang) - parseFloat(totalPembayaran);
            //Hasil sisa Uang Masukkan Ke Value 
            if (jumlahUang == "") {
                $('.sisa_uang').val("");
            } else {
                $('.sisa_uang').val(sisaUang);

                let sisaUangx = $('.sisa_uang').val();
                $('.sisa_uang').autoNumeric('set', sisaUangx);
            }
        });

        $('.formPembayaran').submit(function(e) {
            e.preventDefault();
            //1.Validasi Form Pembayaran 
            //Cek Kondisi Jika Sudah DiTekan Submit Apakah Inputan Pembayaran Kosong
            //Ambil Inputan Jumlah Uangnya dan total pembayaran
            let sisaUang = ($('.sisa_uang').val() == "") ? 0 : $('.sisa_uang').autoNumeric('get');
            let jumlahUang = ($('.jumlah_uang').val() == "") ? 0 : $('.jumlah_uang').autoNumeric('get');

            if (parseFloat(jumlahUang) == 0 || parseFloat(jumlahUang) == "") {
                //Kalau Jumlah Uang Kosong
                Toast.fire({
                    icon: 'warning',
                    title: 'Uang Belum DiInput'
                })
            } else if (parseFloat(sisaUang) < 0) {
                //Kalau Sisa Uang Minus
                Toast.fire({
                    icon: 'warning',
                    title: 'Uang Belum Mencukupi'
                })
            } else {
                //Simpan Data
                $.ajax({
                    type: "post",
                    url: $(this).attr('action'), //Url diambil dari form action
                    data: $(this).serialize(), //Data nya diambil dari yg ada diform input
                    success: function(response) {
                        //Jika Sukses
                        if (response == 'berhasil') {
                            Swal.fire({
                                title: 'Cetak Struk ?',
                                text: "Apakah Yakin Mau Di Cetak ? ",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Ya, cetak !'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    //Redirect Ke Print Struk Jika Tidak Ingin Langsung Redirect
                                    //window.location = "/penjualan/print";

                                    //Jika Ingin Langsung Redirect Pakai Ajax 
                                    $.ajax({
                                        type: "post",
                                        url: "<?= base_url(); ?>/penjualan/struk",
                                        data: {
                                            invoice: $('#strukinvoice').val(),
                                            kasir: $('#strukkasir').val(),
                                            totalPembayaran: $('#total_pembayaran').val(),
                                            jumlahUang: $('#jumlah_uang').val(),
                                            sisaUang: $('#sisa_uang').val()
                                        },
                                        success: function(response) {
                                            //Kalau Berhasil
                                            if (response == "Berhasil Mencetak Struk") {
                                                Swal.fire({
                                                    title: 'Invoice ' + $('#strukinvoice').val(),
                                                    text: response,
                                                    icon: 'success'
                                                }).then((result) => {
                                                    window.location.reload();
                                                })
                                            } else {
                                                Swal.fire({
                                                    title: 'Invoice ' + $('#strukinvoice').val(),
                                                    text: "Gagal Cetak, Printer Gagal Terkoneksi",
                                                    icon: 'error'
                                                }).then((result) => {
                                                    window.location.reload();
                                                })
                                            }


                                        }
                                    });
                                } else {
                                    window.location.reload();
                                }
                            })
                        }
                    }
                });
            }

            return false;
        });


    });

    function selesai() {
        setTimeout(function() {
            update();
            selesai();
        }, 3000);
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
                        <button class="badge badge-sm light badge-danger" data-toggle="modal" data-target="#DetailPembayaran${data.id}">Detail</button>
                        <button class="btn btn-sm light btn-primary" data-toggle="modal" data-target="#ModalPembayaran${data.id}">Bayar</button>
                        </td>
                        </tr>'
                        `
                )
            });
        });

    }

    function prosesPembayaran() {
        let invoice = $('#invoice').val();
        alert(invoice);

    }
</script>


<?= $this->endSection(); ?>