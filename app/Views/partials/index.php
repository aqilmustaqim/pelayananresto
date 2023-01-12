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
    <link href="<?= base_url(); ?>/assets/css/style.css" rel="stylesheet">
    <link href="https://cdn.lineicons.com/2.0/LineIcons.css" rel="stylesheet">

</head>

<body>

    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">

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


</body>

</html>