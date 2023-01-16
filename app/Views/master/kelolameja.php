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
                        <h4 class="card-title">Data Meja</h4>
                        <button class="btn btn-info" data-toggle="modal" data-target="#TambahDataMeja"><i class="fa fas fa-user-plus"></i>Tambah Data Meja</button>
                    </div>

                    <div id="card-view">
                        <div class="row">
                            <?php foreach ($meja as $m) : ?>
                                <div class="col-md-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between">
                                                <div class="media">

                                                    <div class="m-l-10">
                                                        <h5 class="m-b-0">Meja <?= $m['nomor_meja']; ?></h5>

                                                    </div>
                                                </div>

                                            </div>

                                            <div class="m-t-30">
                                                <div class="d-flex justify-content-between">
                                                    <span class="font-weight-semibold">Status</span>

                                                </div>
                                                <div class="progress progress-sm m-t-10">
                                                    <div class="progress-bar <?= ($m['status_meja'] == 1 ? 'bg-danger' : 'bg-success'); ?>" role="progressbar" style="width: 100%"></div>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="m-t-20">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <span class="badge badge-pill <?= ($m['status_meja'] == 1 ? 'badge-danger' : 'badge-success'); ?>"><?= ($m['status_meja'] == 1 ? 'Dipakai' : 'Kosong'); ?></span>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
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
<div class="modal fade" id="TambahDataMeja">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Meja</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <i class="anticon anticon-close"></i>
                </button>
            </div>

            <?= csrf_field(); ?>
            <div class="modal-body">
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label>Nomor Meja</label>
                        <input type="text" id="nomor_meja" name="nomor_meja" class="form-control" placeholder="Masukkan Nomor Meja..." required>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary tombol-tambah-meja">Tambah</button>
            </div>

        </div>
    </div>
</div>

<?= $this->endSection(); ?>