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
                        helo
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
        $('.hamburger').addClass('is-active');
    })
</script>



<?= $this->endSection(); ?>