<?= $this->extend('partials/index'); ?>
<?= $this->section('content'); ?>
<!--**********************************
            Content body start
 ***********************************-->
<div class="content-body">
    <!-- row -->
    <div class="container-fluid">
        <div class="form-head d-flex mb-3 align-items-start">
            <div class="mr-auto d-none d-lg-block">
                <h2 class="text-primary font-w600 mb-0">Dashboard</h2>
                <p class="mb-0">Welcome to RestoServe <b><?= session()->get('nama'); ?>!</b></p>
            </div>

        </div>
    </div>
</div>
<!--**********************************
            Content body end
 ***********************************-->
<?= $this->endSection(); ?>