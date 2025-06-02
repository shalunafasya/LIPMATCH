<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>home - Dashboard</title>

    <link href="<?= base_url() ?>assets/template/vendor/fontawesome-free/css/all.min.css" rel="stylesheet"
        type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link href="<?= base_url() ?>assets/template/css/sb-admin-2.min.css" rel="stylesheet">

    <style type="text/css">
        body {
            background-color: #FBD8DC !important;
            font-family: 'Nunito', sans-serif;
            color: #4a2c36;
        }

        .card.shadow.mb-7 {
            background-color: #fafafa;
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(255, 182, 193, 0.3);
            padding: 25px 30px;
            margin-bottom: 40px;
        }

        .btn-custom {
            background-color: #ea84b4 !important;
            border-color: #ea84b4 !important;
            color: white !important;
            border-radius: 25px;
            padding: 10px 25px;
            font-weight: 600;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }

        .btn-custom:hover,
        .btn-custom:focus {
            background-color: #f57fb6 !important;
            border-color: #f57fb6 !important;
            box-shadow: 0 0 8px #ea84b4;
        }

        .btn-back {
            background-color: #f8d7da !important;
            border-color: #f8d7da !important;
            color: #a33c52 !important;
            border-radius: 25px;
            padding: 10px 25px;
            font-weight: 600;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }

        .btn-back:hover,
        .btn-back:focus {
            background-color: #ea84b4 !important;
            border-color: #ea84b4 !important;
            color: white !important;
            box-shadow: 0 0 8px #ea84b4;
        }

        .pretty-btn {
            display: inline-block;
            margin: 5px;
            border-radius: 30px;
            background-color: #f8d7da;
            border: 1px solid #f5c2c7;
            cursor: pointer;
            transition: background-color 0.3s, color 0.3s;
        }

        .pretty-btn input[type="radio"] {
            display: none;
        }

        .pretty-btn span {
            display: inline-block;
            padding: 8px 15px;
            font-weight: 600;
            color: #a33c52;
            border-radius: 30px;
            width: 100%;
        }

        .pretty-btn:hover span {
            background-color: #ea84b4;
            color: white;
        }

        .pretty-btn input[type="radio"]:checked+span {
            background-color: #ea84b4;
            color: white;
        }
    </style>
</head>

<body>

    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                <div class="row ml-4">
                    <div class="d-sm-flex align-items-center justify-content-between mb-">
                        <h1 class="h6 mb-0 text-primary"
                            style="font-family: 'Poppins', sans-serif; font-size: 26px; font-weight: 600; letter-spacing: 1px;">
                            LIPMATCH</h1>
                    </div>
                    <div class="row ml-3"></div>
                </div>
            </nav>

            <div class="container-fluid">
                <div class="card shadow mb-7">
                    <h1 class="h6 ml-1 mb-2 text-gray-800">Kenali kondisi bibir anda dengan mengisi kuesioner
                        permasalahan bibir yang anda alami di bawah ini:</h1>
                    <form method="post" action="<?= base_url('User/Jenis_Bibir/proses_perhitungan') ?>">
                        <div class="card-body">

                            <!-- SESSION 1 -->
                            <div id="session1">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <div class="form-group">
                                        <label><?= $i . ". Apakah " . $List_Kriteria[$i - 1]['kriteria'] ?></label>
                                        <div class="btn-group-toggle d-flex flex-wrap">
                                            <?php
                                            $options = [
                                                'kriteria tidak terlihat' => 'Tidak Terlihat',
                                                'kriteria kurang terlihat' => 'Kurang Terlihat',
                                                'kriteria cukup terlihat' => 'Cukup Terlihat',
                                                'kriteria jelas terlihat' => 'Jelas Terlihat'
                                            ];
                                            foreach ($options as $val => $label): ?>
                                                <label class="pretty-btn m-1 flex-fill text-center">
                                                    <input type="radio" name="nilai_bobot<?= $i ?>" value="<?= $val ?>">
                                                    <span><?= $label ?></span>
                                                </label>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                <?php endfor; ?>
                                <div class="d-flex justify-content-end mt-4">
                                    <button type="button" class="btn btn-custom"
                                        onclick="document.getElementById('session1').style.display='none'; document.getElementById('session2').style.display='block';">
                                        Selanjutnya >></button>
                                </div>
                            </div>

                            <!-- SESSION 2 -->
                            <div id="session2" style="display: none;">
                                <?php for ($i = 6; $i <= 10; $i++): ?>
                                    <div class="form-group">
                                        <label><?= $i . ". Apakah " . $List_Kriteria[$i - 1]['kriteria'] ?></label>
                                        <div class="btn-group-toggle d-flex flex-wrap">
                                            <?php foreach ($options as $val => $label): ?>
                                                <label class="pretty-btn m-1 flex-fill text-center">
                                                    <input type="radio" name="nilai_bobot<?= $i ?>" value="<?= $val ?>">
                                                    <span><?= $label ?></span>
                                                </label>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                <?php endfor; ?>
                                <div class="d-flex justify-content-between mt-4">
                                    <button type="button" class="btn btn-back"
                                        onclick="document.getElementById('session2').style.display='none'; document.getElementById('session1').style.display='block';">
                                        << Kembali</button>

                                            <button type="button" class="btn btn-custom"
                                                onclick="document.getElementById('session2').style.display='none'; document.getElementById('session3').style.display='block';">
                                                Lanjut >></button>
                                </div>
                            </div>

                            <!-- SESSION 3 -->
                            <div id="session3" style="display: none;">
                                <?php for ($i = 11; $i <= 15; $i++): ?>
                                    <div class="form-group">
                                        <label><?= $i . ". Apakah " . $List_Kriteria[$i - 1]['kriteria'] ?></label>
                                        <div class="btn-group-toggle d-flex flex-wrap">
                                            <?php foreach ($options as $val => $label): ?>
                                                <label class="pretty-btn m-1 flex-fill text-center">
                                                    <input type="radio" name="nilai_bobot<?= $i ?>" value="<?= $val ?>">
                                                    <span><?= $label ?></span>
                                                </label>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                <?php endfor; ?>
                                <div class="d-flex justify-content-between mt-4">
                                    <button type="button" class="btn btn-back"
                                        onclick="document.getElementById('session3').style.display='none'; document.getElementById('session2').style.display='block';">
                                        << Kembali</button>

                                            <button type="submit" class="btn btn-custom">Simpan</button>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>

                <footer class="sticky-footer">
                    <div class="container my-auto">
                        <div class="copyright text-center my-auto">
                            <span>Copyright &copy; 2025 Luna. All rights reserved.</span>
                        </div>
                    </div>
                </footer>

                <a class="scroll-to-top rounded" href="#page-top">
                    <i class="fas fa-angle-up"></i>
                </a>
            </div>
        </div>
    </div>

    <script src="<?= base_url() ?>assets/template/vendor/jquery/jquery.min.js"></script>
    <script src="<?= base_url() ?>assets/template/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url() ?>assets/template/vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="<?= base_url() ?>assets/template/js/sb-admin-2.min.js"></script>

</body>

</html>