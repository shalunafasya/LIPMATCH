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

        $kategoriSoal = [
            'normal'     => [1, 2, 3, 4, 5],
            'kering'     => [5, 6, 7, 8, 9],
            'gelap'      => [4, 10, 11, 12],
            'kombinasi'  => [13, 14, 15],
        ];

        $BT = [];
        foreach ($kategoriSoal as $kategori => $soals) {
            $BT[$kategori] = 0;
            foreach ($soals as $no) {
                $BT[$kategori] += $bobot[$no][0]->bobot;
            }
        }

        $probabilitas = [];
        foreach ($kategoriSoal as $kategori => $soals) {
            foreach ($soals as $no) {
                $probabilitas[$kategori][$no] = $BT[$kategori] > 0 
                    ? $bobot[$no][0]->bobot / $BT[$kategori]
                    : 0;
            }
        }

        $NA_bobot = [];
        foreach ($kategoriSoal as $kategori => $soals) {
            foreach ($soals as $no) {
                $NA_bobot[$kategori][$no] = ($bobot[$no][0]->bobot / 2) * $probabilitas[$kategori][$no];
            }
        }

        $AT = [];
        foreach ($NA_bobot as $kategori => $values) {
            $AT[$kategori] = array_sum($values);
        }

        $p_normal     = $AT['normal'] * 100 * 2;
        $p_kering     = $AT['kering'] * 100 * 2;
        $p_gelap      = $AT['gelap'] * 100 * 2;
        $p_kombinasi  = $AT['kombinasi'] * 100 * 2;

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

        $product_ids = array_column($list_produk, 'id_produk');
        session()->set('SESS_KBS_PRODUK_HASIL', $product_ids);
        
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
        $produk_hasil = session()->get('SESS_KBS_PRODUK_HASIL') ?? [];

        if (empty($produk_hasil)) {
            return redirect()->to('User/Jenis_Bibir/proses_perhitungan')->with('error', 'Silakan lakukan proses perhitungan terlebih dahulu.');
        }

        $filter_id = [];
        $filter_semua = $this->request->getPost('filter_semua'); 
        $filter_produk = $this->request->getPost('filter_produk');

        if ($filter_semua !== 'all' && is_array($filter_produk)) {
            $filter_id = array_map('intval', $filter_produk);
        }

        $list_produk = $this->kbs_m->getProdukByIds($produk_hasil); 

        if (!empty($filter_id)) {
            $list_produk = array_filter($list_produk, function ($produk) use ($filter_id) {
                return in_array($produk->id_jl, $filter_id);

            });
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

        $data = session()->get('SESS_KBS_LIPSTIK_RESULT');
        $data['list_produk'] = $list_produk;
        $data['filters'] = $this->kbs_m->getAllFilter();
        $data['question'] = $this->kbs_m->getSusQuestion();
        $data['has_submit'] = $has_submit || false;

        return view('user/sidebar_user') . view('user/hasil', $data);
    }
}
