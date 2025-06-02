<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 shadow-sm">
            <div class="container-fluid">
                <span class="navbar-brand mb-0 h1">Dashboard CSAT</span>
            </div>
        </nav>

        <div class="container-fluid">
            <!-- Row for CSAT Score -->
            <div class="row mb-4">
                <div class="col-md-4 offset-md-4">
                    <div class="card text-center shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Skor CSAT</h5>
                            <h1 class="display-4 text-primary"><?= number_format($skor_CSAT, 2, ',', '.') ?></h1>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-12 text-right">
                    <form method="post" action="/admin/reset-csat"
                        onsubmit="return confirm('Yakin ingin menghapus semua data CSAT?');">
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash-alt"></i> Reset Data CSAT
                        </button>
                    </form>
                </div>
            </div>

            <!-- Row for Table -->
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h6 class="m-0">Detail Jawaban CSAT</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover" id="myTable">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>#</th>
                                            <th>User ID</th>
                                            <th>Question ID</th>
                                            <th>Rating</th>
                                            <th>Tanggal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $number = 1; ?>
                                        <?php foreach ($csat_feedback as $cf): ?>
                                            <tr>
                                                <td><?= $number++; ?></td>
                                                <td><?= $cf['user_id'] ?></td>
                                                <td><?= $cf['question_id'] ?></td>
                                                <td><?= $cf['rating'] ?></td>
                                                <td><?= $cf['created_at'] ?></td>
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