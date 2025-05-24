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
                        <form method="POST" enctype="multipart/form-data" action="<?= site_url("admin/Produk/proses_editdata/" . $data_produk['id_produk']); ?>">
                            <div class="form-group row mt-3 mr-2 ml-2">
                                <label for="jenis_lipstik" class="col-sm-3 col-form-label">Jenis Lipstik</label>
                                <div class="col-sm-9">
                                    <select name="jenis_lipstik" class="form-control">
                                        <?php foreach ($List_JS as $list) : ?>
                                            <option value="<?= $list['id_jl'] ?>" <?= $list['id_jl'] == $data_produk['jenis_lipstik'] ? 'selected' : '' ?>>
                                                <?= $list['jenis_lipstik'] ?>
                                            </option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row mt-3 mr-2 ml-2">
                                <label for="merek_produk" class="col-sm-3 col-form-label">Merek</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="merek_produk" name="merek_produk" value="<?= $data_produk['merk_produk'] ?>" required>
                                </div>
                            </div>

                            <div class="form-group row mt-3 mr-2 ml-2">
                                <label for="nama_produk" class="col-sm-3 col-form-label">Nama Produk</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="nama_produk" name="nama_produk" value="<?= $data_produk['nama_produk'] ?>" required>
                                </div>
                            </div>

                            <div class="form-group row mt-3 mr-2 ml-2">
                                <label class="col-sm-3 col-form-label">Kondisi Bibir</label>
                                <div class="col-sm-9">
                                    <div class="border rounded p-3">
                                        <?php
                                        $selected_jb = isset($data_produk['id_JB']) ? explode(',', $data_produk['id_JB']) : [];
                                        ?>
                                        <?php foreach ($List_JB as $list): ?>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="kondisi_bibir[]" id="jb<?= $list['id_JB'] ?>" value="<?= $list['id_JB'] ?>"
                                                    <?= in_array($list['id_JB'], $selected_jb) ? 'checked' : '' ?>>
                                                <label class="form-check-label" for="jb<?= $list['id_JB'] ?>">
                                                    <?= $list['nama_JB'] ?>
                                                </label>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mt-3 mr-2 ml-2">
                                <label class="col-sm-3 col-form-label">Tone Kulit</label>
                                <div class="col-sm-9">
                                    <div class="border rounded p-3">
                                        <?php
                                    $selected_tk = isset($data_produk['tone_kulit']) ? explode(',', $data_produk['tone_kulit']) : [];
                                    ?>
                                    <?php foreach ($List_TK as $list): ?>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="tone_kulit[]" id="tk<?= $list['id_tk'] ?>" value="<?= $list['id_tk'] ?>"
                                                <?= in_array($list['id_tk'], $selected_tk) ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="tk<?= $list['id_tk'] ?>">
                                                <?= $list['tone_kulit'] ?>
                                            </label>
                                        </div>
                                    <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>


                            <div class="form-group row mt-3 mr-2 ml-2">
                                <label for="harga" class="col-sm-3 col-form-label">Harga Produk</label>
                                <div class="col-sm-9">
                                    <input type="number" min="0" class="form-control" id="harga" value="<?= $data_produk['harga'] ?>" name="harga_produk" required>
                                </div>
                            </div>

                            <div class="form-group row mt-3 mr-2 ml-2">
                                <label for="image" class="col-sm-3 col-form-label">Upload Gambar</label>
                                <div class="col-sm-9">
                                    <input type="file" class="form-control" id="gambar" name="image" accept="image/png, image/jpeg, image/jpg, image/gif">
                                    <!-- Menampilkan gambar lama jika ada -->
                                    <?php if (!empty($data_produk['gambar'])): ?>
                                        <img src="<?= base_url('assets/image/produk/' . $data_produk['gambar']) ?>" alt="Gambar Produk" style="max-width: 100px; margin-top: 10px;">
                                    <?php endif; ?>
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
