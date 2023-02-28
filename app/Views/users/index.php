<?= $this->extend('partials/index'); ?>
<?= $this->section('content'); ?>


<!--**********************************
            Content body start
        ***********************************-->
<div class="content-body">
    <div class="container-fluid">


        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Data Users</h4>

                    <div class="users" data-users="<?= session()->getFlashdata('users'); ?>"></div>
                </div>
            </div>

        </div>

        <div class="row">

            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <button class="btn btn-primary" data-toggle="modal" data-target="#TambahDataUser"><i class="fa fas fa-user-plus"></i>Tambah Data User</button>
                        <div class="table-responsive">
                            <table class="table table-sm mb-0 table-striped">
                                <thead>
                                    <tr>

                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Status</th>
                                        <th>Bergabung</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="customers">
                                    <?php foreach ($users as $u) : ?>
                                        <tr class="btn-reveal-trigger">
                                            <td class="py-3">
                                                <div class="media d-flex align-items-center">
                                                    <div class="media-body">
                                                        <h5 class="mb-0 fs--1"><?= $u['nama']; ?></h5>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="py-2"><?= $u['email']; ?></td>
                                            <td class="py-2">
                                                <?php
                                                if ($u['role_id'] == 1) {
                                                    echo '<span class="badge badge-pill badge-primary font-size-12"> Admin </span>';
                                                } else if ($u['role_id'] == 2) {
                                                    echo '<span class="badge badge-pill badge-danger font-size-12"> Pelayan </span>';
                                                } else if ($u['role_id'] == 3) {
                                                    echo '<span class="badge badge-pill badge-info font-size-12"> Koki Dine In </span>';
                                                } else if ($u['role_id'] == 4) {
                                                    echo '<span class="badge badge-pill badge-dark font-size-12"> Kasir </span>';
                                                } else if ($u['role_id'] == 5) {
                                                    echo '<span class="badge badge-pill badge-success font-size-12"> Koki Take Away </span>';
                                                }

                                                ?>
                                            </td>
                                            <td class="py-2">
                                                <?php
                                                if ($u['is_active'] == 1) {
                                                    echo '<span class="badge badge-pill badge-black font-size-12"> Aktif </span>';
                                                } else if ($u['is_active'] == 0) {
                                                    echo '<span class="badge badge-pill badge-black font-size-12"> Tidak Aktif </span>';
                                                }

                                                ?>
                                            </td>
                                            <td class="py-2"><i><?= date('d-M-Y', strtotime($u['created_at'])); ?></i></td>
                                            <td>
                                                <a href="" class="badge badge-info" data-toggle="modal" data-target="#UbahDataModal<?= $u['id_users']; ?>"><i class="fa fas fa-edit"></i></a>
                                                <a href="" class="badge badge-danger" data-toggle="modal" data-target="#ResetPasswordModal<?= $u['id_users']; ?>"><i class="fa fa-solid fa-key"></i></a>
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

<div class="modal fade" id="TambahDataUser">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data User</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <i class="anticon anticon-close"></i>
                </button>
            </div>

            <?= csrf_field(); ?>
            <div class="modal-body">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Nama</label>
                        <input type="text" id="nama" name="nama" class="form-control" placeholder="Masukkan Nama User..." required>
                    </div>

                    <div class="form-group col-md-6">
                        <label>Email</label>
                        <input type="text" id="email" name="email" class="form-control" placeholder="Masukkan email User..." required>
                    </div>


                    <div class="form-group col-md-6">
                        <label>Password</label>
                        <input type="password" id="password" name="password" class="form-control" placeholder="Masukkan password User..." required>
                    </div>

                    <div class="form-group col-md-6">
                        <label>Pilih Role...</label>
                        <select id="role" name="role" class="form-control" tabindex="-98">

                            <?php foreach ($role as $r) : ?>
                                <option value="<?= $r['id']; ?>"><?= $r['role']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>


                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary tombol-tambah-user">Tambah</button>
            </div>

        </div>
    </div>
</div>

<!-- Ubah Data Modal -->

<?php foreach ($users as $u) : ?>
    <div class="modal fade" id="UbahDataModal<?= $u['id_users']; ?>">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Data User</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <i class="anticon anticon-close"></i>
                    </button>
                </div>
                <form action="<?= base_url('users/ubahUser'); ?>/<?= $u['id_users']; ?>" method="post">
                    <?= csrf_field(); ?>
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Nama</label>
                                <input type="text" name="nama" class="form-control" value="<?= $u['nama']; ?>" required>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Email</label>
                                <input type="text" name="email" class="form-control" value="<?= $u['email']; ?>" required>
                            </div>


                            <div class="form-group col-md-6">
                                <label>Ubah Role...</label>
                                <select id="inputState" name="role" class="form-control" tabindex="-98">
                                    <option value="<?= $u['id_role']; ?>" selected><?= $u['role']; ?></option>
                                    <?php foreach ($role as $r) : ?>
                                        <option value="<?= $r['id']; ?>"><?= $r['role']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Status...</label>
                                <select id="inputState" name="is_active" class="form-control" tabindex="-98">
                                    <option value="<?= $u['is_active']; ?>" selected><?= ($u['is_active'] == 1 ? 'Aktif' : 'Tidak Aktif'); ?></option>
                                    <option value="1">Aktif</option>
                                    <option value="0">Tidak Aktif</option>
                                </select>
                            </div>
                        </div>



                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary tombol-ubah">Ubah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<?php foreach ($users as $u) : ?>
    <div class="modal fade" id="ResetPasswordModal<?= $u['id_users']; ?>">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Reset Password <b><?= $u['nama']; ?></b></h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <i class="anticon anticon-close"></i>
                    </button>
                </div>
                <form action="<?= base_url('users/resetPassword'); ?>/<?= $u['id_users']; ?>" method="post">
                    <?= csrf_field(); ?>
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label>Password Reset</label>
                                <input type="password" name="password" class="form-control" placeholder="Masukkan Password ..." required>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary tombol-reset-password">Reset Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach; ?>
<?= $this->endSection(); ?>