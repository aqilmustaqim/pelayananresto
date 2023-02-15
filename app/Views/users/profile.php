<?= $this->extend('partials/index'); ?>
<?= $this->section('content'); ?>

<!--**********************************
            Content body start
        ***********************************-->
<div class="content-body">
    <div class="container-fluid">
        <!-- row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="profile card card-body px-3 pt-3 pb-0">
                    <div class="profile-head">

                        <div class="profile-info">
                            <div class="profile-photo">
                                <img src="<?= base_url('assets'); ?>/images/avatar/<?= $users['foto']; ?>" class="img-fluid rounded-circle" alt="">
                            </div>
                            <div class="profile-details">
                                <div class="profile-name px-3 pt-2">
                                    <h4 class="text-primary mb-0"><?= session()->get('nama'); ?></h4>
                                    <p>
                                        <?php
                                        if (session()->get('role_id') == 1) {
                                            echo 'Admin';
                                        } else if (session()->get('role_id') == 2) {
                                            echo 'Pelayan';
                                        } else if (session()->get('role_id') == 3) {
                                            echo 'Koki Dine In';
                                        } else if (session()->get('role_id') == 4) {
                                            echo 'Kasir';
                                        } else if (session()->get('role_id') == 5) {
                                            echo 'Koki Take Away';
                                        }
                                        ?>


                                    </p>
                                </div>
                                <div class="profile-email px-2 pt-2">
                                    <h4 class="text-muted mb-0"><?= date('d-M-Y', strtotime($users['created_at'])); ?></h4>
                                    <p>Bergabung</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="swal" data-swal="<?= session()->getFlashdata('profile-success'); ?>"></div>
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <div class="profile-tab">
                            <div class="custom-tab-1">
                                <?php if (session()->getFlashdata('profile')) : ?>
                                    <div class="alert alert-danger" role="alert">
                                        <?= session()->getFlashdata('profile'); ?>
                                    </div>
                                <?php endif; ?>
                                <?php if ($validation->hasError('password_baru')) : ?>
                                    <div class="alert alert-danger" role="alert">
                                        <?= $validation->getError('password_baru'); ?>
                                    </div>
                                <?php endif; ?>
                                <?php if ($validation->hasError('password_lama')) : ?>
                                    <div class="alert alert-danger" role="alert">
                                        <?= $validation->getError('password_lama'); ?>
                                    </div>
                                <?php endif; ?>
                                <?php if ($validation->hasError('konfirmasi_password_baru')) : ?>
                                    <div class="alert alert-danger" role="alert">
                                        <?= $validation->getError('konfirmasi_password_baru'); ?>
                                    </div>
                                <?php endif; ?>

                                <ul class="nav nav-tabs">
                                    <li class="nav-item"><a href="#profile-settings" data-toggle="tab" class="nav-link active show">Setting</a>
                                    </li>
                                    <li class="nav-item"><a href="#about-me" data-toggle="tab" class="nav-link">Change Password</a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div id="profile-settings" class="tab-pane fade active show">
                                        <div class="pt-3">
                                            <div class="settings-form">
                                                <h4 class="text-primary">Edit Profile</h4>

                                                <div class="form-row">
                                                    <input type="hidden" name="id" id="id" value="<?= $users['id']; ?>">
                                                    <div class="form-group col-md-4">
                                                        <label>Nama</label>
                                                        <input type="text" name="nama" id="nama" value="<?= $users['nama']; ?>" class="form-control">
                                                    </div>


                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-12">
                                                        <label>Email</label>
                                                        <input type="email" name="email" id="email" value="<?= $users['email']; ?>" class="form-control" readonly>
                                                    </div>
                                                </div>
                                                <button class="btn btn-primary" id="tombol-edit-profile" type="button">Edit Profile</button>

                                            </div>
                                        </div>
                                    </div>
                                    <div id="about-me" class="tab-pane fade">

                                        <div class="pt-3">
                                            <div class="settings-form">

                                                <form action="<?= base_url(); ?>/users/changePassword/<?= $users['id']; ?>" method="post">
                                                    <div class="form-row">
                                                        <div class="form-group col-md-12">
                                                            <label>Password Lama</label>
                                                            <input type="password" name="password_lama" id="password_lama" placeholder="Masukkan Password Lama ..." class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="form-group col-md-6">
                                                            <label>Password Baru</label>
                                                            <input type="password" name="password_baru" id="password_baru" placeholder="Masukkan Password Baru..." class="form-control">
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label>Konfirmasi Password Baru</label>
                                                            <input type="password" name="konfirmasi_password_baru" id="konfirmasi_password_baru" placeholder="Konfirmasi Password Baru..." class="form-control">
                                                        </div>
                                                    </div>
                                                    <button class="btn btn-primary tombol-change-password" type="submit">Edit Password</button>
                                                </form>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('#tombol-edit-profile').on('click', function() {

        let nama = $('#nama').val();
        let id = $('#id').val();

        if (nama == '') {
            Swal.fire({
                title: 'Nama',
                text: 'Nama Tidak Boleh Kosong',
                icon: 'warning'
            });
        } else {
            //Kasi Sweet Alert Konfirmasi
            Swal.fire({
                title: 'Apakah Anda Yakin?',
                html: `Mengubah Profile`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Iya, Proses !'
            }).then((result) => {
                if (result.isConfirmed) {
                    //Jalankan Ajax
                    $.ajax({
                        type: "post",
                        url: "<?= base_url(); ?>/users/updateprofile",
                        data: {
                            id: id,
                            nama: nama
                        },
                        dataType: "json",
                        success: function(data) {
                            if (data == "1") {
                                Swal.fire({
                                    title: 'Profile Berhasil Di Update',
                                    text: 'Silahkan Login Ulang ! ',
                                    icon: 'success'
                                }).then((result) => {
                                    window.location.href = "<?= base_url(); ?>/auth/logout";

                                })

                            }
                        }
                    });
                }
            })
        }
    });
</script>

<?= $this->endSection(); ?>