<style type="text/css">
    .btnfaved {
        background-color: #ccc !important;
        color: white;
        font-weight: bold;
        border-radius: 12px;
    }

    .btn-filter {
  background-color: white;
  color: #e87bb2;
  border: 2px solid #e87bb2;
  border-radius: 20px;
  font-weight: bold;
  padding: 10px 20px;
  box-shadow: 0 2px 5px rgba(0,0,0,0.1);
  transition: all 0.2s ease-in-out;
}
.btn-filter:hover {
  background-color: #fce7f0;
  color: #e87bb2;
}

@media (min-width: 1200px) {
  .col-lg-2-4 {
    flex: 0 0 20%;
    max-width: 20%;
  }
}

.custom-card .card-img-top {
    height: 170px;
    object-fit: contain;
    padding-top: 10px;
}

.custom-card .badge-warning {
    font-size: 24px; /* ubah ke 16px kalau mau lebih besar */
    padding: 6px 10px;
}

.custom-card .badge-warning {
    font-size: 16px;
    font-weight: 600;
    padding: 6px 12px;
    border-radius: 12px;
}


.custom-card .card-body {
    padding: 8px;
}

.custom-card .card-text {
    font-size: 12px;
    margin-top: 5px;
}

.custom-card .badge,
.custom-card .text-muted,
.custom-card .btn {
    font-size: 11px;
}

    .checked {
        color: orange;
    }

    .rating {
        cursor: pointer;
    }

    .emoji {
        font-size: 40px;
        margin: 5px;
        cursor: pointer;
        filter: grayscale(100%);
        transition: transform 0.2s, filter 0.2s;
    }

    .emoji:hover {
        transform: scale(1.2);
    }

    .emoji.selected {
        filter: grayscale(0%);
    }

    .badge-warning {
    background-color:rgb(255, 196, 0);
    color: white;
    font-weight: bold;
}

</style>

<!-- Sidebar Toggler (Sidebar) -->
<div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>
</ul>
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
            
            <h1 class="h6 mb-0 text-primary"
                style="font-family: 'Poppins', sans-serif; font-size: 26px; font-weight: 600; letter-spacing: 1px;">
                LIPMATCH
            </h1>

            <a href="<?= base_url('user/awal') ?>" class="btn btn-danger btn-sm"
            style="position: fixed; top: 15px; right: 20px; z-index: 9999; font-family: 'Poppins', sans-serif;">
            <i class="fas fa-sign-out-alt"></i> Keluar
            </a>    

            </div>
            <div class="row ml-3"></div>
            </li>
            </ul>
        </nav>
        <div class="container-fluid">
            <div class="container">
                <div class="card rounded-lg mt-5 mb-5">
                    <div class="card-body">
                        <div class="table-responsive float-right">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <h1 class="text-uppercase">
                                    <?= session('SESS_KBS_LIPSTIK_NAMA') ? 'Hi.. ' . session('SESS_KBS_LIPSTIK_NAMA') : ''; ?>
                                </h1>
                                <h1 class="h6 ml-1 mb-3 text-gray-800">hasil skor kondisi bibir anda sebagai berikut :
                                </h1>
                                <thead>
                                    <tr class="bg-info text-white">
                                        <th>NORMAL</th>
                                        <th>KERING</th>
                                        <th>GELAP</th>
                                        <th>KOMBINASI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><?= number_format($p_normal, 2) ?>%</td>
                                        <td><?= number_format($p_kering, 2) ?>%</td>
                                        <td><?= number_format($p_gelap, 2) ?>%</td>
                                        <td><?= number_format($p_kombinasi, 2) ?>%</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <h1 class="h6 ml-5 mb-3 text-danger font-italic">*catatan : untuk hasil yang lebih jelas, anda bisa
                        melakukan konsultasi langsung dengan ahli </h1>
                    <div class="container">
                        <div class="row my-4">
                        <div class="col-12 d-flex justify-content-end">
                            <button class="btn btn-light shadow-sm px-4 py-2 fw-bold" data-toggle="modal" data-target="#filterModal" style="border-radius: 20px; color: #e87bb2; border: 2px solid #e87bb2;">
                            <i class="fas fa-sliders-h me-1"></i> Filter
                            </button>
                        </div>
                        </div>
                        <div class="row my-4">
                            <?php foreach ($list_produk as $list): ?>
                                <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-3">
                                    <class class="card">
                                        <img class="card-img-top"
                                            src="<?= base_url("/assets/image/produk/" . $list->gambar) ?>">
                                        <div class="card-body" style="height: 150px">
                                            <div class="row mb-2">
                                                <div class="col-6">
                                                    <span class="badge badge-danger badge-sm">
                                                        <?= $list->jenis_lipstik ?>
                                                    </span>
                                                </div>
                                                <div class="col-6">
                                                    <div class="float-right">
                                                        <small class="text-right">
                                                            <i class="fas fa-fw fa-heart text-danger"></i>
                                                            <span id="love-count-<?= $list->id_produk ?>" class="text-danger">
                                                                <?= $list->rekomendasi ?>
                                                            </span>
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>
                                            <span class="text-muted">
                                                Rp <?= number_format($list->harga, 0, '', '.') ?>
                                            </span>
                                            <span class="float-right text-muted font-weight-bold">
                                                <sup class="badge badge-sm badge-primary">
                                                    <?= $list->merk_produk ?>
                                                </sup>
                                            </span>
                                            <p class="mt-2 card-text font-weight-bold">
                                                <?= $list->nama_produk ?>
                                            </p>
                                        </div>
                                        <div class="card-footer">
                                        <div>
                                            <button 
                                                class="btn btn-sm px-4 py-2" 
                                                style="background-color:rgb(250, 187, 218); color: white; font-weight: bold; border-radius: 12px;" 
                                                onclick="showDescription(<?= $list->id_produk ?>)">
                                                Description
                                            </button>
                                            
                                            <button 
                                                onclick="favIt(this)" 
                                                data-id="<?= $list->id_produk ?>" 
                                                class="btn btn-sm px-3 py-2" 
                                                style="background-color: #e87bb2; color: white; font-weight: bold; border-radius: 12px;">
                                                Fav It!
                                            </button>
                                        </div>
                                    </div>
                                    </class>
                                </div>
                            <?php endforeach; ?>
                            <div id="recommendation-container" class="mt-5 mb-5 p-4 rounded shadow-sm" 
                                style="background-color: #fef9f9; border-top: 2px dashed #ffb3b3; width: 100%">
                                <h6 class="text-center mb-4" style="
                                    font-family: 'Poppins', sans-serif;
                                    font-weight: 500;
                                    font-size: 15px;
                                    color: #d6336c;
                                    background-color: #fff0f5;
                                    display: inline-block;
                                    padding: 8px 16px;
                                    border-radius: 20px;
                                    border: 1px dashed #f5b5c0;
                                    margin: 0 auto;
                                ">
                                    ✨ Produk pilihan dari pengguna dengan preferensi serupa ✨
                                </h6>

                                <div id="loading-spinner" class="text-center my-4 text-muted" style="display: none;">
                                    <div class="spinner-border text-danger" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                    <p class="mt-2">Memuat rekomendasi terbaru...</p>
                                </div>

                                <!-- LIST PRODUK RENDER DI SINI -->
                                <div id="recommendation-list"></div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="filterModalLabel">Filter Produk</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="<?= base_url('User/Jenis_Bibir/rekomendasi') ?>" method="post">
                        <div class="modal-body">
                            <input type="checkbox" id="all-checked-button" name="filter_semua" value="all" checked
                                onchange="selectAllFilter(this)">
                            &nbsp; &nbsp; <label for="all-checked-button">semua</label>
                            <br>
                            <?php foreach ($filters as $filter): ?>
                                <input type="checkbox" class="list_filter" id="id-<?= $filter['id_jl'] ?>"
                                    onclick="checkFilterCondition(this)" name="filter_produk[]"
                                    value="<?= $filter['id_jl'] ?>" checked>
                                &nbsp; &nbsp; <label
                                    for="id-<?= $filter['id_jl'] ?>"><?= $filter['jenis_lipstik'] ?></label>
                                <br>
                            <?php endforeach; ?>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">TAMPILKAN FILTER</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="recommendationModal" tabindex="-1" aria-labelledby="recommendationModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" style="min-width: 80% !important">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="recommendationModalLabel">Rekomendasi Untuk Kamu</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-striped table-hovered">
                            <thead>
                                <th>#</th>
                                <th>Nama Produk</th>
                                <th>Harga</th>
                                <th>Merk</th>
                                <th>Jenis Produk</th>
                            </thead>
                            <tbody id="list-recommendation">
                                <tr>
                                    <td colspan="4" class="text-center">Sedang proses...</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="feedbackModal" tabindex="-1" aria-labelledby="feedbackModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" style="max-width: 70% !important">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="feedbackModalLabel">Rating Feedback</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="<?= base_url('User/KBSController/submit_sus_feedback') ?>" method="post">
                        <div class="modal-body text-center">
                            <?php $number = 1; ?>
                            <?php foreach ($question as $quest): ?>
                                <section>
                                    <p><?= $number ?>. <?= $quest['soal'] ?></p>
                                    <div>
                                        <input type="hidden" name="soal_<?= $number ?>" id="soal-<?= $number ?>">
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <span class="fa fa-star rate-<?= $quest['id'] ?> rating"
                                                onclick="giveRate(this, <?= $quest['id'] ?>, <?= $i ?>, <?= $number ?>)"></span>
                                        <?php endfor; ?>
                                    </div>
                                    <br>
                                    <?php $number++ ?>
                                </section>
                            <?php endforeach; ?>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Belum</button>
                            <button type="submit" class="btn btn-primary" onclick="hasSubmitFeedback()">Kirimkan
                                Feedback</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="csatModal" tabindex="-1" aria-labelledby="csatModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="csatModalLabel">Feedback Kepuasan Anda</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="<?= base_url('User/KBSController/submit_csat_feedback') ?>" method="post">
                        <div class="modal-body text-center">
                            <p>Bagaimanakah tingkat kepuasan Anda terhadap hasil rekomendasi yang didapatkan dari
                                website LIPMATCH?</p>
                            <div class="emoji-options">
                                <span class="emoji" onclick="setCSATEmoji(this, 1)">😡</span>
                                <span class="emoji" onclick="setCSATEmoji(this, 2)">😕</span>
                                <span class="emoji" onclick="setCSATEmoji(this, 3)">😐</span>
                                <span class="emoji" onclick="setCSATEmoji(this, 4)">🙂</span>
                                <span class="emoji" onclick="setCSATEmoji(this, 5)">🤩</span>
                                <input type="hidden" name="csat_1" id="csat-1">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Kirimkan Feedback</button>
                        </div>
                    </form>

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
        <!-- Scroll to Top Button-->
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>
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


        <?php $has_submit = session()->get('has_submit') ?? 'false'; ?>

        <script type="text/javascript">
            let wasRate = false;
            let pause = false;

            document.addEventListener('DOMContentLoaded', () => {
                <?php if (session()->getFlashdata('show_csat')): ?>
                    $('#csatModal').modal('show');
                <?php endif; ?>
            });

            let answer = {};

            let selectedProduct = [];

            const saveMyRecommendation = async (allID) => {
                return await axios.get(`<?= base_url('User/KBSController/save_my_recommendation/') ?>${allID}`).then(res => res.data);
            }

            const deleteMyRecommendation = async (id) => {
                return await axios.get(`<?= base_url('User/KBSController/delete_my_recommendation/') ?>${id}`).then(res => res.data);
            }

            const getProfileMatchingRecommendation = async () => {
                return await axios.get(`<?= base_url('User/KBSController/profile_matching') ?>`).then(res => res.data);
            }
            
            const getRankingEmoji = (index) => {
                switch(index) {
                    case 0: return '🥇'; // Juara 1
                    case 1: return '🥈'; // Juara 2
                    case 2: return '🥉'; // Juara 3
                    case 3: return '🎖️'; // Ranking 4
                    case 4: return '🏅'; // Ranking 5
                    default: return '🏷️'; // cadangan
                }
            };


            const showProfileMatchRecommendation = async () => {
                console.info('Algoritma dijalankan...');
                const spinner = document.getElementById('loading-spinner');
                const listContainer = document.getElementById('recommendation-list');

                if (spinner) spinner.style.display = 'block';
                if (listContainer) listContainer.innerHTML = '';
                const result = await getProfileMatchingRecommendation();
                console.log('result', result);

                let html = ``;

                if (result.products && result.products.length > 0) {
                    html += `<div class="row mt-4">`;
                    console.log(result.products);
                    result.products.slice(0, 5).forEach((res, index) => {
                        html += `
                            <div class="col-6 col-sm-4 col-md-3 col-lg-2-4 mb-3 custom-card">
                                <div class="card">
                                    <img class="card-img-top" src="${'<?= base_url("/assets/image/produk/") ?>' + res.gambar}">
                                    <div class="card-body" style="height: 135px">
                                        <div class="row mb-1">
                                            <div class="col-6">
                                                <span class="badge badge-pill badge-warning">
                                                    ${getRankingEmoji(index)} #${index + 1}
                                                </span>
                                                <span class="badge badge-danger badge-sm">${res.jenis_lipstik}</span>
                                            </div>
                                            <div class="col-6 text-right">
                                                <small>
                                                    <i class="fas fa-fw fa-heart text-danger"></i>
                                                    <span class="text-danger">${res.rekomendasi}</span>
                                                </small>
                                            </div>
                                        </div>
                                        <span class="text-muted" style="font-size: 12px;">Rp ${parseInt(res.harga).toLocaleString('id-ID')}</span>
                                        <span class="float-right text-muted font-weight-bold" style="font-size: 11px;">
                                            <sup class="badge badge-sm badge-primary">${res.merk_produk}</sup>
                                        </span>
                                        <p class="mt-1 card-text font-weight-bold" style="font-size: 12px;">${res.nama_produk}</p>
                                    </div>
                                    <div class="card-footer text-center">
                                        <button 
                                            class="btn btn-sm px-3 py-1" 
                                            style="background-color:rgb(250, 187, 218); color: white; font-weight: bold; border-radius: 12px; font-size: 11px;" 
                                            onclick="showDescription(${res.id_produk})">
                                            Description
                                        </button>
                                    </div>
                                </div>
                            </div>
                        `;
                    });

                    html += `</div>`;
                } else {
                    html = `<tr><td colspan="5" class="text-center text-danger">Tidak ada rekomendasi ditemukan</td></tr>`;
                }

                if (spinner) spinner.style.display = 'none';
                if (listContainer) listContainer.innerHTML = html;
            };


            const giveRate = (target, questId, starId, number) => {
                console.info(questId, starId);
                const stars = document.querySelectorAll(`.rate-${questId}`);

                stars.forEach((res, index) => {
                    // console.log(res);
                    if ((index + 1) <= starId) {
                        res.classList.add('checked');
                    } else {
                        res.classList.remove('checked');
                    }
                });

                answer[`soal_${questId}`] = starId;

                document.getElementById(`soal-${number}`).value = starId;

                console.info(answer);
            }

            function showDescription(idProduk) {
                axios.get(`<?= base_url('User/KBSController/get_product_description/') ?>${idProduk}`)
                    .then(res => {
                        const deskripsi = res.data.deskripsi;
                        const namaProduk = res.data.nama_produk;

                        Swal.fire({
                            title: `<span style="color:#d63384; font-size: 20px;">${namaProduk}</span>`,
                            html: `
                                <div style="text-align: left; font-size: 16px; padding: 10px; color: #333;">
                                    ${deskripsi}
                                </div>`,
                            icon: 'info',
                            confirmButtonColor: '#d63384',
                            confirmButtonText: 'Tutup',
                            background: '#fff0f5',
                            customClass: {
                                popup: 'shadow-lg rounded-4',
                                confirmButton: 'px-4 py-2 fw-bold'
                            }
                        });
                    })
                    .catch(err => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops 😥',
                            text: 'Terjadi kesalahan saat mengambil deskripsi.',
                            confirmButtonColor: '#d63384'
                        });
                    });
            }

            const favIt = async (target) => {
                const id = target.getAttribute('data-id');
                const isFaved = target.classList.contains('faved');
                const loveCountEl = document.getElementById(`love-count-${id}`);
                let currentCount = parseInt(loveCountEl?.innerText || '0');

                if (!isFaved) {
                    await saveMyRecommendation(id);

                    target.classList.remove('btn-primary');
                    target.classList.add('btnfaved', 'faved');
                    target.innerText = 'Fav It!';

                    if (loveCountEl) loveCountEl.innerText = currentCount + 1;

                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Ditambahkan ke rekomendasi!',
                        showConfirmButton: false,
                        timer: 1500
                    });

                } else {
                    await deleteMyRecommendation(id);

                    target.classList.remove('btnfaved', 'faved');
                    target.classList.add('btn-primary');
                    target.innerText = 'Fav It!';

                    if (loveCountEl && currentCount > 0) loveCountEl.innerText = currentCount - 1;

                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'info',
                        title: 'Dibatalkan dari rekomendasi',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }

                await showProfileMatchRecommendation();
            };


            const selectAllFilter = async (target) => {
                const listFilter = document.querySelectorAll('.list_filter');

                listFilter.forEach(res => {
                    res.checked = target.checked;
                });
            }

            const checkFilterCondition = async (target) => {
                const listFilter = document.querySelectorAll('.list_filter');

                let numOfChecked = 0;

                listFilter.forEach(res => {
                    if (res.checked) {
                        numOfChecked += 1;
                    }
                });

                document.getElementById('all-checked-button').checked = (numOfChecked == listFilter.length);
            }

            const hasSubmitFeedback = () => {
                wasRate = true;
            }

            const setCSATRating = (rating) => {
                document.getElementById('csat-1').value = rating;
                const stars = document.querySelectorAll('#csatModal .fa-star');
                stars.forEach((star, index) => {
                    if (index < rating) {
                        star.classList.add('checked');
                    } else {
                        star.classList.remove('checked');
                    }
                });
            };

            function setCSATEmoji(element, value) {
                document.querySelectorAll('.emoji').forEach(el => el.classList.remove('selected'));
                element.classList.add('selected');
                document.getElementById('csat-1').value = value;
            }

            const showRateModal = async () => {
                pause = true;

                setTimeout(() => {
                    pause = false;
                }, 30000);

                $("#feedbackModal").modal();
            }

            document.addEventListener('DOMContentLoaded', () => {
                var has_submit = '<?= $has_submit ?>';
                console.log("DEBUG has_submit:", has_submit);


                if (has_submit === 'false' || has_submit === '0' || has_submit === '') {
                    console.info("Belum submit, timer 30 detik jalan...");
                    triggerModalWithDelay();
                }

                // kalau modal SUS ditutup pakai tombol X
                document.querySelector('#feedbackModal .close')?.addEventListener('click', () => {
                    console.log("Modal SUS ditutup, tunggu 30 detik lagi...");
                    triggerModalWithDelay();
                });

                    setTimeout(() => {
                        showProfileMatchRecommendation();
                    }, 1500);

            });

            function triggerModalWithDelay() {
                setTimeout(() => {
                    if (!wasRate) {
                        showRateModal();
                    }
                }, 30000); // tunggu 30 detik
            }

        </script>
        </body>

        </html>