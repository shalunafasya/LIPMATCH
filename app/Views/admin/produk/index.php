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

    .badge.badge-info {
        background-color: #F7C6D1 !important;
        /* pink muda lembut */
        color: #5A2A3A !important;
        /* coklat gelap */
        font-weight: 600;
        border-radius: 0.25rem;
        /* radius badge, bisa disesuaikan */
    }
</style>

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
            <div class="container-fluid">
                <span class="navbar-brand mb-0 h1" style="color: #EA84B4">Dashboard Kelola Data Produk</span>
            </div>
        </nav>

        <div class="container-fluid">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <a href="<?= base_url('admin/Produk/tambah_data') ?>"
                        class="btn btn-success mr-1 font-weight-bold"><i class="fas  fa-print"></i> Tambah Data</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive float-right">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr class="bg-info text-white">
                                    <th>Jenis Lipstik</th>
                                    <th>Merek</th>
                                    <th>Nama Produk</th>
                                    <th>Kondisi Bibir</th>
                                    <th>Tone Kulit</th>
                                    <th>Gambar</th>
                                    <th>Harga</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php foreach ($List_Produk as $Produk): ?>
                                    <tr>
                                        <td><?= $Produk['jenis_lipstik'] ?></td>
                                        <td><?= $Produk['merk_produk'] ?></td>
                                        <td><?= $Produk['nama_produk'] ?></td>
                                        <td>
                                            <?php
                                            $selected_jb = isset($Produk['id_JB']) ? explode(',', $Produk['id_JB']) : [];

                                            if (!empty($selected_jb)) {
                                                foreach ($selected_jb as $id) {
                                                    foreach ($List_JB as $jb) {
                                                        if ((int) $jb['id_JB'] === (int) trim($id)) {
                                                            echo '<span class="badge badge-info mr-1">' . $jb['nama_JB'] . '</span>';
                                                        }
                                                    }
                                                }
                                            } else {
                                                echo '<small class="text-muted">-</small>';
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            $selected_ids = isset($Produk['id_tk']) ? explode(',', $Produk['id_tk']) : [];

                                            if (!empty($selected_ids)) {
                                                foreach ($selected_ids as $id) {
                                                    foreach ($List_TK as $tk) {
                                                        if ((int) $tk['id_tk'] === (int) trim($id)) {
                                                            echo '<span class="badge badge-info mr-1">' . $tk['tone_kulit'] . '</span>';
                                                        }
                                                    }
                                                }
                                            } else {
                                                echo '<small class="text-danger">Tidak ada tone kulit</small>';
                                            }
                                            ?>
                                        </td>
                                        <td><img src="<?= base_url("/assets/image/produk/" . $Produk['gambar']) ?>"
                                                width="100" height="100"></td>
                                        <td><?= $Produk['harga'] ?></td>
                                        <td>
                                            <a href="<?= base_url() ?>admin/Produk/editdata/<?= $Produk['id_produk'] ?>"><button
                                                    type="button" class="btn btn-success btn-icon-text">Edit</button></a>
                                            <a href="<?= base_url() ?>admin/Produk/hapusdata/<?= $Produk['id_produk'] ?>"><button
                                                    type="button" class="btn btn-danger btn-icon-text">Hapus</button></a>
                                        </td>
                                    </tr>
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
        <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

</div>

<script>
    $(document).ready(function () {
        $('#dataTable').DataTable();
    });
</script>