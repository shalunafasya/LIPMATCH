<style>
    /* Style header tabel */
    #dataTable thead tr {
        background-color: #F7C6D1;
        color: #5A2A3A;
        /* coklat gelap */
        font-weight: 700;
        border-bottom: 3px solid #EA84B4;
    }

    /* Style teks header */
    #dataTable thead th {
        padding: 12px 15px;
        text-align: left;
        letter-spacing: 0.05em;
    }

    /* Border kanan di th */
    #dataTable thead th {
        border-right: 1px solid #d6a7b8;
    }

    /* Hilangkan border kanan di th terakhir */
    #dataTable thead th:last-child {
        border-right: none;
    }

    /* Baris zebra */
    #dataTable tbody tr:nth-child(even) {
        background-color: #fff0f5;
        /* pink sangat pucat */
    }

    #dataTable tbody tr:nth-child(odd) {
        background-color: #ffffff;
    }
</style>


<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
            <div class="container-fluid">
                <span class="navbar-brand mb-0 h1" style="color: #EA84B4">Dashboard Kelola Data Jenis Bibir</span>
            </div>
        </nav>

        <div class="container-fluid">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <!-- <h6 class="m-0 font-weight-bold text-primary">Data Siswa</h6> -->
                    <a href="<?= base_url('admin/Jenis_Bibir/tambah_data') ?>"
                        class="btn btn-success mr-1 font-weight-bold"><i class="fas  fa-print"></i> Tambah Data</a>

                </div>
                <div class="card-body">
                    <div class="table-responsive float-right">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr class="bg-info text-white">
                                    <th>No</th>
                                    <th>Kondisi Bibir</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php foreach ($List_JB as $JB): ?>
                                    <tr>
                                        <td><?= $i ?></td>
                                        <td><?= $JB['nama_JB'] ?></td>
                                        <td>
                                            <a href="<?= base_url() ?>admin/Jenis_Bibir/editdata/<?= $JB['id_JB'] ?>"><button
                                                    type="button" class="btn btn-success btn-icon-text">Edit</button></a>
                                            <a href="<?= base_url() ?>admin/Jenis_Bibir/hapusdata/<?= $JB['id_JB'] ?>"><button
                                                    type="button" class="btn btn-danger btn-icon-text">Hapus</button></a>
                                        </td>
                                    </tr>
                                    <?php $i++; ?>
                                <?php endforeach ?>
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
    </div>
</div>
</div>