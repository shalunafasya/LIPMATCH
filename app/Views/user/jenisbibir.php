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
    <link href="<?= base_url() ?>assets/template/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?= base_url() ?>assets/template/css/sb-admin-2.min.css" rel="stylesheet">
    <style type="text/css">
         body {
    background: linear-gradient(135deg, #fbd8dc 0%, #ffffff 100%);
    font-family: 'Poppins', sans-serif;
    color: #7a3f62;
    min-height: 100vh;
    margin: 0;
    padding: 40px 20px;
  }
  .container {
    max-width: 900px;
    margin: 0 auto;
    padding-left: 30px;
    padding-right: 30px;
  }
  h1.page-title {
    font-weight: 700;
    font-size: 1.8rem;
    letter-spacing: 0.05em;
    color: #b95a8a;
    text-transform: uppercase;
    margin-bottom: 40px;
    text-shadow: 1px 1px 2px rgba(234, 132, 180, 0.35);
  }

  p.intro-text {
    color: #b46590;
    font-weight: 600;
    font-size: 1.1rem;
    margin-bottom: 40px;
    letter-spacing: 0.02em;
    line-height: 1.5;
  }

  .card {
    background: #ffffff;
    border-radius: 20px;
    padding: 40px 45px;
    box-shadow:
      0 4px 8px rgba(234, 132, 180, 0.15),
      0 10px 20px rgba(234, 132, 180, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }
  .card:hover {
    transform: translateY(-8px);
    box-shadow:
      0 10px 20px rgba(234, 132, 180, 0.25),
      0 20px 40px rgba(234, 132, 180, 0.2);
  }

  .form-group {
    margin-bottom: 30px;
  }

  .form-group label {
    display: block;
    font-weight: 600;
    font-size: 16px;
    color: #a85c86;
    margin-bottom: 15px;
    cursor: pointer;
  }

  .custom-control {
    position: relative;
    padding-left: 28px;
    margin-right: 25px;
    cursor: pointer;
    user-select: none;
    display: inline-flex;
    align-items: center;
    margin-bottom: 15px;
  }

  .custom-control-input {
    position: absolute;
    opacity: 0;
    cursor: pointer;
    height: 0;
    width: 0;
  }

  .custom-control-label {
    font-weight: 500;
    font-size: 14px;
    color: #925378;
    cursor: pointer;
    transition: color 0.3s ease;
  }

  .custom-control-input:checked + .custom-control-label {
    color: #ea84b4 !important;
    font-weight: 700;
    text-shadow: 0 0 3px #ea84b4;
  }

  .custom-control-input + .custom-control-label:hover {
    color: #d46a9c;
  }

  .custom-control-label::before {
    content: "";
    display: inline-block;
    position: absolute;
    left: 0;
    top: 50%;
    transform: translateY(-50%);
    width: 18px;
    height: 18px;
    border: 2px solid #ea84b4;
    border-radius: 50%;
    background: white;
    transition: border-color 0.3s ease;
  }

  .custom-control-input:checked + .custom-control-label::before {
    background: #ea84b4;
    border-color: #ea84b4;
    box-shadow: 0 0 6px rgba(234, 132, 180, 0.6);
  }

  .btn-info {
    background: linear-gradient(135deg, #ea84b4, #fbd8dc);
    border: none;
    border-radius: 30px;
    padding: 14px 32px;
    font-weight: 700;
    font-size: 18px;
    color: white;
    box-shadow: 0 4px 12px rgba(234, 132, 180, 0.6);
    transition: box-shadow 0.3s ease, transform 0.2s ease;
    cursor: pointer;
    margin-top: 30px;
    width: 100%;
  }

  .btn-info:hover {
    box-shadow: 0 6px 20px rgba(234, 132, 180, 0.9);
    transform: translateY(-3px);
  }

  @media (max-width: 768px) {
    .card {
      padding: 25px 20px;
    }
    .btn-info {
      font-size: 16px;
      padding: 14px;
    }
    .custom-control {
      margin-right: 15px;
    }
  }
</style>
</head>

<body>

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">


            <!-- Topbar -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                <!-- Sidebar Toggle (Topbar) -->
                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                    <i class="fa fa-bars"></i>
                </button>

                <!-- Page Heading -->
                <div class="row ml-4">
                    <div class="d-sm-flex align-items-center justify-content-between ">
                        <h1 class="h6 mb-10 text-gray-700 text-uppercase"> REKOMENDASI PRODUK LIPSTIK <?= isset($_SESSION['nama']) ? 'UNTUK ' . $_SESSION['nama'] : ''; ?> BERDASARKAN KONDISI BIBIR</h1>
                    </div>
                </div>

                </li>
                </ul>
            </nav>
            <div class="container-fluid">
                <div class="card shadow mb-7  ">
                    <h1 class="h3 ml-5 mb-3"></h1>
                    <h1 class="h6 ml-1 mb-2 text-gray-800">Kenali kondisi bibir anda dengan mengisi kuesioner permasalahan bibir yang anda alami di bawah ini : </h1>
                    <form method="post" action="<?= base_url('User/Jenis_Bibir/proses_perhitungan') ?>">
                        <div class="card-body">
                            <?php $i = 1; ?>
                            <?php foreach ($List_Kriteria as $kriteria) : ?>

                                <div class="form-group">
                                    <label class="form-check-label"> <?= $i . " Apakah " . $kriteria['kriteria'] ?></label>
                                    <div class="">
                                        <div class="custom-control custom-radio custom-control-inline ml-3 mt-1  ">
                                            <input class="form-check-input" type="radio" name="<?= "nilai_bobot" . $i ?>" value="kriteria tidak terlihat">
                                            <label class="form-check-label" for="inlineRadio1">kriteria tidak terlihat</label>
                                        </div>

                                        <div class="custom-control custom-radio custom-control-inline ml-3 ">
                                            <input class="form-check-input" type="radio" name="<?= "nilai_bobot" . $i ?>" value="kriteria kurang terlihat">
                                            <label class="form-check-label" for="inlineRadio1">kriteria kurang terlihat</label>
                                        </div>

                                        <div class="custom-control custom-radio custom-control-inline ml-3 ">
                                            <input class="form-check-input" type="radio" name="<?= "nilai_bobot" . $i ?>" value="kriteria cukup terlihat">
                                            <label class="form-check-label" for="inlineRadio1">kriteria cukup terlihat</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline  ml-3">
                                            <input class="form-check-input" type="radio" name="<?= "nilai_bobot" . $i ?>" value="kriteria jelas terlihat">
                                            <label class="form-check-label" for="inlineRadio1">kriteria jelas terlihat</label>
                                        </div>
                                    </div>
                                </div>

                                <?php $i++ ?>
                            <?php endforeach ?>

                            <div class=" float-right form-group ">
                                <button type="submit" class=" float-right btn btn-info">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Footer -->
                <footer class="sticky-footer bg-white">
                    <div class="container my-auto">
                        <div class="copyright text-center my-auto">
                            <span>Copyright &copy; 2025 Luna. All rights reserved.</span>
                        </div>
                    </div>
                </footer>

                <!-- Scroll to Top Button-->
                <a class="scroll-to-top rounded" href="#page-top">
                    <i class="fas fa-angle-up"></i>
                </a>
            </div>
        </div>
    </div>
    <!-- Bootstrap core JavaScript-->
    <script src="<?= base_url() ?>assets/template/vendor/jquery/jquery.min.js"></script>
    <script src="<?= base_url() ?>assets/template/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?= base_url() ?>assets/template/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?= base_url() ?>assets/template/js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="<?= base_url() ?>assets/template/vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="<?= base_url() ?>assets/template/js/demo/chart-area-demo.js"></script>
    <script src="<?= base_url() ?>assets/template/js/demo/chart-pie-demo.js"></script>

</body>

</html>