<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title><?= $title; ?></title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url(); ?>/assets/images/favicon.png">
    <link href="<?= base_url(); ?>/assets/vendor/jqvmap/css/jqvmap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url(); ?>/assets/vendor/chartist/css/chartist.min.css">
    <link href="<?= base_url(); ?>/assets/vendor/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
    <!-- DataTables -->
    <!-- Datatable -->
    <link href="<?= base_url(); ?>/assets/vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet">

    <link href="<?= base_url(); ?>/assets/css/style.css" rel="stylesheet">
    <link href="https://cdn.lineicons.com/2.0/LineIcons.css" rel="stylesheet">

    <!-- Sweet Alert 2 -->
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.min.css'>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" />

</head>

<body>

    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper" class="show">

        <!--**********************************
            Nav header start
        ***********************************-->
        <?= $this->include('partials/navbar'); ?>
        <!--**********************************
            Nav header end
        ***********************************-->

        <!--**********************************
            Header start
        ***********************************-->
        <?= $this->include('partials/header') ?>
        <!--**********************************
            Header end ti-comment-alt
        ***********************************-->

        <!--**********************************
            Sidebar start
        ***********************************-->
        <?= $this->include('partials/sidebar'); ?>
        <!--**********************************
            Sidebar end
        ***********************************-->

        <?= $this->renderSection('content'); ?>

        <!--**********************************
            Footer start
        ***********************************-->
        <?= $this->include('partials/footer'); ?>
        <!--**********************************
            Footer end
        ***********************************-->

    </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->

    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
    <script src="<?= base_url(); ?>/assets/vendor/global/global.min.js"></script>
    <script src="<?= base_url(); ?>/assets/vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
    <script src="<?= base_url(); ?>/assets/vendor/chart.js/Chart.bundle.min.js"></script>
    <script src="<?= base_url(); ?>/assets/js/custom.min.js"></script>
    <script src="<?= base_url(); ?>/assets/js/deznav-init.js"></script>

    <!-- Counter Up -->
    <script src="<?= base_url(); ?>/assets/vendor/waypoints/jquery.waypoints.min.js"></script>
    <script src="<?= base_url(); ?>/assets/vendor/jquery.counterup/jquery.counterup.min.js"></script>

    <!-- Apex Chart -->
    <script src="<?= base_url(); ?>/assets/vendor/apexchart/apexchart.js"></script>

    <!-- Chart piety plugin files -->
    <script src="<?= base_url(); ?>/assets/vendor/peity/jquery.peity.min.js"></script>

    <!-- Dashboard 1 -->
    <script src="<?= base_url(); ?>/assets/js/dashboard/dashboard-1.js"></script>



    <!-- JQUERY -->


    <!-- SweetAlert2 -->
    <!-- <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.all.min.js"></script>

    <!-- Datatable -->
    <script src="<?= base_url(); ?>/assets/vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="<?= base_url(); ?>/assets/js/plugins-init/datatables.init.js"></script>

    <!-- AutoNumeric -->
    <script src="<?= base_url(); ?>/assets/js/autoNumeric.js"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/autonumeric@4.1.0"></script> -->

    <!-- Js Sendiri -->
    <script src="<?= base_url(); ?>/assets/js/myscript.js"></script>

    <script>
        // Users
        $('.tombol-tambah-user').on('click', function() {
            //Ambil Inputan
            let nama = $('#nama').val();
            let email = $('#email').val();
            let password = $('#password').val();
            let role = $('#role').val();

            if (nama == '') {
                Swal.fire({
                    title: 'Data User ',
                    text: 'Nama Tidak Boleh Kosong !',
                    icon: 'error'
                })
            } else if (email == '') {
                Swal.fire({
                    title: 'Data User ',
                    text: 'Email Tidak Boleh Kosong !',
                    icon: 'error'
                })
            } else if (password == '') {
                Swal.fire({
                    title: 'Data User ',
                    text: 'Password Tidak Boleh Kosong !',
                    icon: 'error'
                })
            } else {

                //Jalankan Ajax
                $.ajax({
                    method: "POST",
                    url: "<?= base_url(); ?>/users/tambahUser",
                    data: {
                        nama: nama,
                        email: email,
                        password: password,
                        role: role
                    },
                    success: function(data) {
                        if (data == "berhasil") {
                            Swal.fire({
                                title: 'Data User',
                                text: 'Berhasil Add User !',
                                icon: 'success'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = "<?= base_url(); ?>/users";
                                }
                            })
                        }

                    }
                });

            }

        });

        $('.tombol-ubah-user').on('click', function() {
            //Ambil Inputan

            let id = $('#id').val();
            let nama = $('#nama').val();
            let email = $('#email').val();
            let role = $('#role').val();
            alert(id);

            if (nama == '') {
                Swal.fire({
                    title: 'Data User ',
                    text: 'Nama Tidak Boleh Kosong !',
                    icon: 'error'
                })
            } else if (email == '') {
                Swal.fire({
                    title: 'Data User ',
                    text: 'Email Tidak Boleh Kosong !',
                    icon: 'error'
                })
            } else {

                //Jalankan Ajax


            }

        });
        // END USERS

        // KATEGORI
        $('.tombol-tambah-kategori').on('click', function() {
            //Ambil Inputan
            let kategori = $('#nama_kategori').val();

            if (kategori == '') {
                Swal.fire({
                    title: 'Data Kategori ',
                    text: 'Kategori Tidak Boleh Kosong !',
                    icon: 'error'
                })
            } else {

                //Jalankan Ajax
                $.ajax({
                    method: "POST",
                    url: "<?= base_url(); ?>/master/tambahKategori",
                    data: {
                        kategori: kategori
                    },
                    success: function(data) {
                        if (data == "berhasil") {
                            Swal.fire({
                                title: 'Data Kategori',
                                text: 'Berhasil Add Kategori !',
                                icon: 'success'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = "<?= base_url(); ?>/master/kategori";
                                }
                            })
                        }

                    }
                });

            }

        });
        // END KATEGORI

        // MEJA
        $('.tombol-tambah-meja').on('click', function() {
            //Ambil Inputan
            let meja = $('#nomor_meja').val();

            if (meja == '') {
                Swal.fire({
                    title: 'Data Meja ',
                    text: 'Nomor Meja Tidak Boleh Kosong !',
                    icon: 'error'
                })
            } else {

                //Jalankan Ajax
                $.ajax({
                    method: "POST",
                    url: "<?= base_url(); ?>/master/tambahMeja",
                    data: {
                        meja: meja
                    },
                    success: function(data) {
                        if (data == "berhasil") {
                            Swal.fire({
                                title: 'Data Meja',
                                text: 'Berhasil Add Meja !',
                                icon: 'success'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = "<?= base_url(); ?>/master/kelolameja";
                                }
                            })
                        } else {
                            Swal.fire({
                                title: 'Data Meja',
                                text: 'Meja Sudah Ada ! ',
                                icon: 'error'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = "<?= base_url(); ?>/master/kelolameja";
                                }
                            })
                        }

                    }
                });

            }

        });
        // END MEJA
    </script>


</body>

</html>