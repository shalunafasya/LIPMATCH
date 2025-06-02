<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
            <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                <i class="fa fa-bars"></i>
            </button>
            <div class="d-sm-flex align-items-center justify-content-between mb-">
                <h1 class="h6 ml-1 mb-10 text-info">REKOMENDASI PRODUK LIPSTIK BERDASARKAN KONDISI BIBIR</h1>
            </div>
        </nav>

        <div class="container-fluid">
            <div class="card shadow mb-7">
                <h1 class="h5 ml-3 mb-3 mt-3 text-gray-800">Silahkan Pilih Kondisi Bibir yang Sesuai untuk Mengetahui
                    Rekomendasi Lipstik</h1>
                <form action="" method="post" class="mb-3 mt-2 form-inline">
                    <label for="JB" class="col-sm-2 col-form-label">Kondisi Bibir : </label>
                    <div class="form-group mx-sm-3 mb-0">
                        <select class="custom-select" name="jenis_bibir" id="JB">
                            <option selected value="semua">Pilih Kondisi Bibir anda</option>
                            <option value="1">Kondisi Bibir Normal</option>
                            <option value="2">Kondisi Bibir Kering</option>
                            <option value="3">Kondisi Bibir Gelap</option>
                            <option value="4">Kondisi Bibir Kombinasi</option>
                        </select>
                    </div>
                </form>

                <div class="card-body">
                    <div class="table-responsive float-right">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr class="bg-info text-white">
                                    <th>No</th>
                                    <th>Jenis Lipstik</th>
                                    <th>Merek</th>
                                    <th>Nama Produk</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- AJAX akan isi data di sini -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="sticky-footer bg-white">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>Copyright &copy; 2025 Luna. All rights reserved.</span>
                </div>
            </div>
        </footer>

        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>

        <!-- Scripts -->
        <script src="<?= base_url() ?>assets/template/vendor/jquery/jquery.min.js"></script>
        <script src="<?= base_url() ?>assets/template/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="<?= base_url() ?>assets/template/vendor/jquery-easing/jquery.easing.min.js"></script>
        <script src="<?= base_url() ?>assets/template/js/sb-admin-2.min.js"></script>
        <script src="<?= base_url() ?>assets/template/vendor/chart.js/Chart.min.js"></script>
        <script src="<?= base_url() ?>assets/template/js/demo/chart-area-demo.js"></script>
        <script src="<?= base_url() ?>assets/template/js/demo/chart-pie-demo.js"></script>

        <script>
            $(document).ready(function () {
                load_produk();

                $("#JB").change(function () {
                    load_produk();
                });
            });

            function load_produk() {
                let jenis_bibir = $("#JB").val();
                $.ajax({
                    type: 'get',
                    url: "<?= base_url('User/Rekomendasi/load_produk') ?>",
                    data: { jenis_bibir: jenis_bibir },
                    success: function (data) {
                        $("#dataTable tbody").html(data);
                    }
                });
            }
        </script>

    </div>
</div>