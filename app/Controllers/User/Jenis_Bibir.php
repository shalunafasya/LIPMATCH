<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\User\Kriteria_model;
use App\Models\Admin\JL_model;
use App\Models\KBSModel;
use App\Models\User\JawabanBayes_model;
use App\Models\User\KondisiBibir_model;

class Jenis_Bibir extends BaseController
{
    protected $Kriteria_model;
    protected $JL_model;
    protected $kbs_m;
    protected $jawabanBayes_model;
    protected $KondisiBibir_model;

    public function __construct()
    {
        $this->Kriteria_model = new Kriteria_model();
        $this->JL_model = new JL_model();
        $this->kbs_m = new KBSModel();
        $this->jawabanBayes_model = new JawabanBayes_model();
        $this->KondisiBibir_model = new KondisiBibir_model();
    }

    public function index()
    {
        $data = [
            "List_Kriteria" => $this->Kriteria_model->tampil()
        ];

        return view('user/jenisbibir', $data);
    }

    public function proses_perhitungan()
    {
        session()->set('has_submit', false);

        $ket_bobot = [];
        for ($i = 1; $i <= 15; $i++) {
            $ket_bobot[$i] = $this->request->getPost("nilai_bobot$i");
        }

        $bobot = [];
        for ($i = 1; $i <= 15; $i++) {
            $bobot[$i] = $this->Kriteria_model->cek_bobot($ket_bobot[$i]);
        }

        foreach ($ket_bobot as $no => $id_pertanyaan) {
            $dataInsert = [
                'id_pertanyaan' => $id_pertanyaan,
                'nomor_soal' => $no,
                'jawaban' => $bobot[$no][0]->bobot,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_At' => date('Y-m-d H:i:s')
            ];
            $this->jawabanBayes_model->insert($dataInsert);
            $lastInsertId = $this->jawabanBayes_model->getInsertID();
        }

        $BT_normal = array_sum([
            $bobot[1][0]->bobot,
            $bobot[2][0]->bobot,
            $bobot[3][0]->bobot,
            $bobot[4][0]->bobot,
            $bobot[5][0]->bobot
        ]);
        $BT_kering = array_sum([
            $bobot[6][0]->bobot,
            $bobot[7][0]->bobot,
            $bobot[8][0]->bobot,
            $bobot[9][0]->bobot,
            $bobot[5][0]->bobot
        ]);
        $BT_gelap = array_sum([
            $bobot[10][0]->bobot,
            $bobot[11][0]->bobot,
            $bobot[12][0]->bobot,
            $bobot[4][0]->bobot
        ]);
        $BT_kombinasi = array_sum([
            $bobot[13][0]->bobot,
            $bobot[14][0]->bobot,
            $bobot[15][0]->bobot
        ]);

        $probabilitas = [];
        foreach ($bobot as $key => $value) {
            $bobotValue = $value[0]->bobot;
            if ($bobotValue == 0) {
                $probabilitas[$key] = 0;
            } else {
                switch ($key) {
                    case 1:
                    case 2:
                    case 3:
                    case 4:
                    case 5:
                        $probabilitas[$key] = $bobotValue / $BT_normal;
                        break;
                    case 6:
                    case 7:
                    case 8:
                    case 9:
                    case 5:
                        $probabilitas[$key] = $bobotValue / $BT_kering;
                        break;
                    case 10:
                    case 11:
                    case 12:
                    case 4:
                        $probabilitas[$key] = $bobotValue / $BT_gelap;
                        break;
                    case 13:
                    case 14:
                    case 15:
                        $probabilitas[$key] = $bobotValue / $BT_kombinasi;
                        break;
                }
            }
        }

        $NA_bobot = [];
        foreach ($probabilitas as $key => $value) {
            $NA_bobot[$key] = ($bobot[$key][0]->bobot / 2) * $value;
        }

        $AT_normal = array_sum([$NA_bobot[1], $NA_bobot[2], $NA_bobot[3], $NA_bobot[4], $NA_bobot[5]]);
        $AT_kering = array_sum([$NA_bobot[6], $NA_bobot[7], $NA_bobot[8], $NA_bobot[9], $NA_bobot[5]]);
        $AT_gelap = array_sum([$NA_bobot[10], $NA_bobot[11], $NA_bobot[12], $NA_bobot[4]]);
        $AT_kombinasi = array_sum([$NA_bobot[13], $NA_bobot[14], $NA_bobot[15]]);

        $p_normal = $AT_normal * 100;
        $p_kering = $AT_kering * 100;
        $p_gelap = $AT_gelap * 100;
        $p_kombinasi = $AT_kombinasi * 100;

        $nilai_max = max($p_normal, $p_kering, $p_gelap, $p_kombinasi);

        if ($nilai_max == $p_normal) {
            $id_JB = 1;
        } else if ($nilai_max == $p_kering) {
            $id_JB = 9;
        } else if ($nilai_max == $p_gelap) {
            $id_JB = 13;
        } else {
            $id_JB = 19;
        }

        $nilai = [$p_normal, $p_kering, $p_gelap, $p_kombinasi];
        $tone_kulit = (int) session()->get('SESS_KBS_LIPSTIK_TONE_KULIT');

        if (count(array_unique($nilai)) == 1) {
            $list_produk = $this->Kriteria_model->all_produk();
        } else {
            $list_produk = $this->Kriteria_model->produk_by_jb_and_tone($id_JB, $tone_kulit);
        }

        $kategori_finansial = session()->get('SESS_KBS_LIPSTIK_KATEGORI_FINANSIAL');

        $range = [
            1 => [0, 50000],
            2 => [50001, 100000],
            3 => [100001, 200000],
            4 => [200001, PHP_INT_MAX]
        ];

        if (isset($range[$kategori_finansial])) {
            [$low, $high] = $range[$kategori_finansial];
            $list_produk = array_filter($list_produk, function ($produk) use ($low, $high) {
                return $produk->harga >= $low && $produk->harga <= $high;
            });
        }

        $produk_log = array_map(function ($p) {
            return $p->id_produk . ' - ' . $p->nama_produk;
        }, $list_produk);

        log_message('debug', 'Hasil produk dari proses_perhitungan: ' . implode(', ', $produk_log));

        session()->set('SESS_KBS_LIPSTIK_CERTAINTY', max($nilai));
        session()->set('SESS_KBS_LIPSTIK_JENIS_BIBIR', $id_JB);
        session()->set('SESS_KBS_LIPSTIK_KATEGORI_FINANSIAL', $kategori_finansial);
        session()->set('SESS_KBS_LIPSTIK_TONE_KULIT', $tone_kulit);

        $dataKondisiBibir = [
            'id_jawaban' => $lastInsertId,
            'normal' => $p_normal,
            'kering' => $p_kering,
            'gelap' => $p_gelap,
            'kombinasi' => $p_kombinasi,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $this->KondisiBibir_model->insert($dataKondisiBibir);

        $data = [
            'p_normal' => $p_normal,
            'p_kering' => $p_kering,
            'p_gelap' => $p_gelap,
            'p_kombinasi' => $p_kombinasi,
            'list_js' => $this->JL_model->tampildata(),
            'show_sus' => true
        ];

        session()->set('SESS_KBS_LIPSTIK_RESULT', $data);
        $data['list_produk'] = $list_produk;
        $data['filters'] = $this->kbs_m->getAllFilter();
        $data['question'] = $this->kbs_m->getSusQuestion();
        $data['has_submit'] = (session()->get('has_submit')) ? '1' : '0';

        log_message('debug', 'Jenis Bibir terdeteksi: ' . $id_JB);
        log_message('debug', 'Tone kulit: ' . $tone_kulit);
        log_message('debug', 'Nilai Probabilitas: Normal=' . $p_normal . ', Kering=' . $p_kering . ', Gelap=' . $p_gelap . ', Kombinasi=' . $p_kombinasi);
        log_message('debug', 'Jumlah produk awal: ' . count($list_produk));
        log_message('debug', 'Kategori finansial: ' . $kategori_finansial);



        return view('user/sidebar_user') . view('user/hasil', $data);
    }

    public function rekomendasi($has_submit = false)
    {
        $filter_id = [];
        if ($this->request->getPost('filter_produk')) {
            $filter_produk = $this->request->getPost('filter_produk');
            if (!array_key_exists('filter_semua', $filter_produk)) {
                $filter_id = array_map('intval', $filter_produk);
            }
        }

        $data = session()->get('SESS_KBS_LIPSTIK_RESULT');
        $id_JB = session()->get('SESS_KBS_LIPSTIK_JENIS_BIBIR');
        $tone_kulit = (int) session()->get('SESS_KBS_LIPSTIK_TONE_KULIT');
        $kategori_finansial = session()->get('SESS_KBS_LIPSTIK_KATEGORI_FINANSIAL');

        $list_produk = $this->Kriteria_model->produk_by_jb_and_filter_tone($id_JB, $filter_id, $tone_kulit);

        $range = [
            1 => [0, 50000],
            2 => [50001, 100000],
            3 => [100001, 200000],
            4 => [200001, PHP_INT_MAX]
        ];

        if (isset($range[$kategori_finansial])) {
            [$low, $high] = $range[$kategori_finansial];
            $list_produk = array_filter($list_produk, function ($produk) use ($low, $high) {
                return $produk->harga >= $low && $produk->harga <= $high;
            });
        }

        log_message('debug', 'Produk sesudah filter finansial: ' . print_r($list_produk, true));

        $data['list_produk'] = $list_produk;
        $data['filters'] = $this->kbs_m->getAllFilter();
        $data['question'] = $this->kbs_m->getSusQuestion();
        $data['has_submit'] = $has_submit || false;

        return view('user/sidebar_user') . view('user/hasil', $data);
    }

}
