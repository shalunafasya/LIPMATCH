        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                </nav>

                <div class="container-fluid">
                    <div class="card shadow mb-4">
                        <div class="row">
    <div class="col">
    <form method="POST" action="<?= site_url('admin/Jenis_Bibir/proses_editdata/' . $dataJB['id_JB']) ?>">
    <div class="form-group">
        <label for="jenis_bibir">Jenis Bibir</label>
        <input type="text" name="jenis_bibir" id="jenis_bibir" class="form-control" value="<?= old('jenis_bibir', $dataJB['nama_JB']) ?>" required>
    </div>
    <button type="submit" class="btn btn-primary">Simpan</button>
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