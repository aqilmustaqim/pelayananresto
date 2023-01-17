<div class="table-responsive">
    <table class="table table-striped">
        <thead class="thead-info">
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Produk</th>
                <th>Jumlah</th>
                <th>Harga</th>
                <th>SubTotal</th>
                <th>#</th>
            </tr>
        </thead>
        <tbody>
            <?php $nomor = 1; ?>
            <?php foreach ($detail as $d) :  ?>
                <?php $subtotal = $d['jumlah'] * $d['harga_produk']; ?>
                <tr>
                    <td><button class="badge badge-dark"><?= $nomor++; ?></button></td>
                    <td><?= $d['kode_produk']; ?></td>
                    <td><?= $d['nama_produk']; ?></td>
                    <td><?= $d['jumlah']; ?></td>
                    <td><?= number_format($d['harga_produk'], 0, ",", "."); ?></td>
                    <td><?= number_format($d['subtotal'], 0, ",", "."); ?> </td>
                    <td>
                        <button class="badge badge-danger" onclick="hapusItem('<?= $d['id_penjualan']; ?>','<?= $d['nama_produk']; ?>')">
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>


    </table>
</div>

<script>
    function hapusItem(id, namaproduk) {
        Swal.fire({
            title: 'Apakah Anda Yakin?',
            html: `Produk <strong>${namaproduk}</strong> Akan DiHapus`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Iya, Hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                //jalankan ajax hapus
                $.ajax({
                    type: "post",
                    url: "<?= base_url() ?>/penjualan/hapusItem",
                    data: {
                        id: id
                    },
                    success: function(response) {
                        if (response == "sukses") {
                            dataDetailPenjualan();
                            kosongkanField();
                        }
                    }
                });
            }
        })
    }
</script>