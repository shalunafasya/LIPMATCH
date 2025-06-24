<!DOCTYPE html>
<html lang="en">
<!-- Content Wrapper -->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>home - Dashboard</title>

    <!-- Custom fonts for this template-->
    <link href="<?= base_url() ?>assets/template/vendor/fontawesome-free/css/all.min.css" rel="stylesheet"
        type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?= base_url() ?>assets/template/css/sb-admin-2.min.css" rel="stylesheet">
    <style type="text/css">
        body {
            background: url(<?= base_url("assets/image/background.jpg"); ?>) no-repeat center center fixed;
            background-size: cover;
            font-family: 'Montserrat', sans-serif;
        }
        .center {
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            padding: 10px;
            text-align: center;
        }
    </style>
</head>

<body>
    <div id="content-wrapper" class="d-flex flex-column flexbox-container">
        <div id="content">
            <div class="text-right pr-4 pt-3">
                <a href="<?= base_url('login') ?>" class="btn btn-outline-light btn-sm" style="background-color: rgba(255, 255, 255, 0.2); color: #fff;">
                    <i class="fas fa-user-shield"></i> Admin Login
                </a>
            </div>
            <div class="center">
                <h1 style="text-align:center;" class=" mb-0 text-primary">LIPMATCH</h1>
                <h3 style="text-align:center;" class=" mt-2 ml-1 mb-3 text-primary ">silahkan masukan data anda </h3>
                <form method="post" action="<?= site_url('User/Awal/simpan_nama') ?>">
                    <?= csrf_field() ?>
                    <input class="form-control" type="text" name="nama" placeholder="Masukkan nama anda..." />
                    <br>
                    <select class="form-control" name="kategori_uang">
                        <option value="">-= Perkiraan Harga yang Anda Inginkan =-</option>
                        <option value="1">&le; Rp 50.000</option>
                        <option value="2">Rp 50.001 - Rp 100.000</option>
                        <option value="3">Rp 100.001 - Rp 200.000</option>
                        <option value="4">&ge; Rp 200.001</option>
                    </select>
                    <select class="form-control" name="cek_tone" required>
                        <option value="" disabled selected hidden>-= Tone Kulit Anda =-</option>
                        <?php foreach ($tone_kulit as $tone): ?>
                            <option value="<?= $tone->id_tk ?>"><?= $tone->tone_kulit ?></option>
                        <?php endforeach; ?>
                    </select>



                    <button type="submit" class="mt-3 btn btn-info">Simpan</button>
                </form>
            </div>
            <!--  </nav> -->
        </div>
    </div>
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    <!-- Bootstrap core JavaScript-->
    <script src="<?= base_url() ?>assets/template/vendor/jquery/jquery.min.js"></script>
    <script src="<?= base_url() ?>assets/template/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?= base_url() ?>assets/template/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?= base_url() ?>assets/template/js/sb-admin-2.min.js"></script>

</body>

</html>