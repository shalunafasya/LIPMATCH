<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Halaman Admin</title>

    <!-- Custom fonts for this template-->
    <link href="<?= base_url() ?>assets/template/vendor/fontawesome-free/css/all.min.css" rel="stylesheet"
        type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?= base_url() ?>assets/template/css/sb-admin-2.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <style type="text/css">
        .nav-item.active,
        .nav-item.active>.nav-link {
            background-color: rgb(242, 180, 209) !important;
            color: white !important;
        }

        .nav-item.active>.nav-link:hover {
            color: white !important;
        }

        .collapse-inner .collapse-item {
            color: white !important;
            border-radius: 0 !important;
            width: 100% !important;
            /* pastikan penuh */
        }

        .collapse-inner .collapse-item.active {
            background-color: rgb(242, 180, 209) !important;
            color: white !important;
            border-radius: 0 !important;
        }

        .collapse-inner .collapse-item:hover {
            background-color: transparent !important;
            color: white !important;
            border-radius: 0 !important;
        }

        .collapse-inner .collapse-item.active:hover {
            background-color: rgb(242, 180, 209) !important;
            color: white !important;
            border-radius: 0 !important;
        }
    </style>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php $segment = service('uri')->getSegment(2); ?>

        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">LIPMATCH</div>
            </a>
            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item <?= ($segment == 'Produk') ? 'active' : '' ?>">
                <a class="nav-link" href="<?= base_url('admin/Produk') ?>">
                    <i class="fas fa-fw fa-archive"></i>
                    <span>Produk</span>
                </a>
            </li>

            <li class="nav-item <?= ($segment == 'Jenis_lipstik') ? 'active' : '' ?>">
                <a class="nav-link" href="<?= base_url('admin/Jenis_lipstik') ?>">
                    <i class="fas fa-fw fa-dice-four"></i>
                    <span>Jenis Lipstik</span>
                </a>
            </li>

            <li class="nav-item <?= ($segment == 'Jenis_bibir') ? 'active' : '' ?>">
                <a class="nav-link" href="<?= base_url('admin/Jenis_bibir') ?>">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Jenis Bibir</span>
                </a>
            </li>

            <li class="nav-item <?= ($segment == 'Tone_Kulit') ? 'active' : '' ?>">
                <a class="nav-link" href="<?= base_url('admin/Tone_Kulit') ?>">
                    <i class="fas fa-fw fa-swatchbook"></i>
                    <span>Tone Kulit</span>
                </a>
            </li>

            <li class="nav-item <?= ($segment == 'Kriteria') ? 'active' : '' ?>">
                <a class="nav-link" href="<?= base_url('admin/Kriteria') ?>">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Kriteria</span>
                </a>
            </li>

            <li class="nav-item <?= ($segment == 'SUS' || $segment == 'CSAT') ?>">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePengujian"
                    aria-expanded="true" aria-controls="collapsePengujian">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Pengujian</span>
                </a>
                <div id="collapsePengujian"
                    class="collapse <?= ($segment == 'SUS' || $segment == 'CSAT') ? 'show' : '' ?>"
                    aria-labelledby="headingPengujian" data-parent="#accordionSidebar">
                    <div class="collapse-inner">
                        <a class="collapse-item <?= ($segment == 'SUS') ? 'active' : '' ?>"
                            href="<?= base_url('admin/SUS') ?>">Pengujian SUS</a>
                        <a class="collapse-item <?= ($segment == 'CSAT') ? 'active' : '' ?>"
                            href="<?= base_url('admin/CSAT') ?>">Pengujian CSAT</a>
                    </div>
                </div>
            </li>
            <!-- Logout Button -->
            <li class="nav-item mt-4 px-3" style="margin-bottom: 20px;">
                <a class="btn btn-sm btn-outline-light btn-block" href="<?= base_url('login') ?>">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </li>
        </ul>

        <!-- End of Sidebar -->