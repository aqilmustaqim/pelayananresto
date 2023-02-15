<?= $this->extend('auth/templates/index'); ?>
<?= $this->section('content'); ?>
<div class="authincation h-100">
    <div class="container h-100">
        <div class="row justify-content-center h-100 align-items-center">
            <div class="col-md-6">
                <div class="authincation-content">
                    <div class="row no-gutters">
                        <div class="col-xl-12">
                            <div class="auth-form">
                                <div class="text-center">
                                    <img src="<?= base_url(); ?>/assets/images/logo/mieaceh1.png" alt="" width="175px">
                                    <h1 class="h2">Mie Aceh Titi Bobrok</h1>
                                    <h4 class="text-center mb-4">Sign in your account</h4>
                                </div>
                                <?php if (session()->getFlashdata('login')) { ?>
                                    <div class="alert alert-danger solid alert-dismissible fade show">
                                        <svg viewBox="0 0 24 24" width="24 " height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="mr-2">
                                            <polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon>
                                            <line x1="15" y1="9" x2="9" y2="15"></line>
                                            <line x1="9" y1="9" x2="15" y2="15"></line>
                                        </svg>
                                        <strong>Error!</strong> <?= session()->getFlashdata('login'); ?> <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span>
                                        </button>
                                    </div>
                                <?php } ?>
                                <form action="<?= base_url(); ?>/auth/loginSave" method="POST">
                                    <div class="form-group">
                                        <label class="mb-1"><strong>Email</strong></label>
                                        <input type="email" class="form-control <?= ($validation->hasError('email') ? 'is-invalid' : ''); ?>" name="email" placeholder="Masukkan Email...">
                                        <div class="invalid-feedback text-left">
                                            <?= $validation->getError('email'); ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="mb-1"><strong>Password</strong></label>
                                        <input type="password" class="form-control <?= ($validation->hasError('password') ? 'is-invalid' : ''); ?>" name="password" placeholder="Masukkan Password...">
                                        <div class="invalid-feedback text-left">
                                            <?= $validation->getError('password'); ?>
                                        </div>
                                    </div>
                                    <div class="form-row d-flex justify-content-between mt-4 mb-2">

                                        <div class="form-group">
                                            <a href="page-forgot-password.html">Forgot Password?</a>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary btn-block">Sign Me In</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>