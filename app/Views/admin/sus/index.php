<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 shadow-sm">
            <div class="container-fluid">
                <span class="navbar-brand mb-0 h1" style="color: #EA84B4">Dashboard SUS</span>
            </div>
        </nav>

        <div class="container-fluid">
            <!-- Row for SUS Score -->
            <div class="row mb-4">
                <div class="col-md-4 offset-md-4">
                    <div class="card text-center shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Skor SUS</h5>
                            <h1 class="display-4 text-primary"><?= number_format($skor_SUS, 2, ',', '.') ?></h1>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-12 text-right">
                    <form method="post" action="/admin/reset-sus"
                        onsubmit="return confirm('Yakin ingin menghapus semua data SUS?');">
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash-alt"></i> Reset Data SUS
                        </button>
                    </form>
                </div>
            </div>

            <!-- Row for Table -->
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h6 class="m-0">Detail Jawaban Feedback</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover" id="myTable">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Feedback ID</th>
                                            <th>Soal</th>
                                            <th>Jawaban</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $number = 1; ?>
                                        <?php foreach ($soal_jawaban as $sj): ?>
                                            <tr>
                                                <td><?= $number++; ?></td>
                                                <td><?= $sj['feedback_id'] ?></td>
                                                <td><?= $sj['soal'] ?></td>
                                                <td><?= $sj['jawaban'] ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="sticky-footer bg-white mt-4">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>&copy; 2025 Luna. All rights reserved.</span>
                </div>
            </div>
        </footer>
        <!-- End of Footer -->

    </div>
    <!-- End of Content -->

</div>
<!-- End of Content Wrapper -->