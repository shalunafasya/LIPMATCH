<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
            <div class="container-fluid">
                <span class="navbar-brand mb-0 h1" style="color: #EA84B4">Dashboard Kelola Data Jenis Lipstik</span>
            </div>
        </nav>

        <div class="container-fluid">
            <div class="card shadow mb-4">
                <div class="row">
                    <div class="col">
                        <form method="POST"
                            action="<?= site_url('admin/Jenis_lipstik/proses_edit_data/' . $data_jenis_lipstik['id_jl']); ?>">
                            <div class="form-group row mt-3 mr-2 ml-2">
                                <label for="jenis_lipstik" class="col-sm-3 col-form-label">Jenis Lipstik</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="jenis_lipstik" name="jenis_lipstik"
                                        value="<?= $data_jenis_lipstik['jenis_lipstik'] ?>">
                                </div>
                            </div>
                            <div class="form-group row mt-3 mr-4 ml-2 float-right">
                                <button type="submit" class="btn btn-info">Simpan</button>
                            </div>
                        </form>
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
    </div>

</div>