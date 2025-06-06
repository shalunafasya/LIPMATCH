<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\KBSModel;

class KBSController extends BaseController
{
    protected $kbs_m;

    public function __construct()
    {
        $this->kbs_m = new KBSModel();
    }

    private function sort_data($data)
    {
        $skor = [];
        foreach ($data as $dt) {
            $skor[$dt['id']] = $dt['NT'];
        }
        array_multisort($skor, SORT_DESC, $data);
        return $data;
    }

    public function profile_matching()
{
    log_message('debug', '=== MASUK KE FUNGSI PROFILE MATCHING ===');

    $session = session();
    $result = [];

    $GAP_mapping = [
        0 => 5.0, 1 => 4.5, -1 => 4.0,
        2 => 3.5, -2 => 3.0,
        3 => 2.5, -3 => 2.0,
        4 => 1.5, -4 => 1.0
    ];

    $normalize_jenis_bibir = [1 => 1, 9 => 2, 13 => 3, 19 => 4];

    function mapKategoriFinansial($harga)
    {
        if ($harga <= 50000) return 1;
        if ($harga <= 100000) return 2;
        if ($harga <= 200000) return 3;
        return 4;
    }

    $kategori_finansial = $session->get('SESS_KBS_LIPSTIK_KATEGORI_FINANSIAL');
    $jenis_bibir = $session->get('SESS_KBS_LIPSTIK_JENIS_BIBIR');
    $certainty = $session->get('SESS_KBS_LIPSTIK_CERTAINTY');
    $tone_kulit = (int) $session->get('SESS_KBS_LIPSTIK_TONE_KULIT');

    log_message('debug', 'CEK SESSI: kategori_finansial=' . $kategori_finansial . ', jenis_bibir=' . $jenis_bibir . ', certainty=' . $certainty . ', tone_kulit=' . $tone_kulit);

    if (empty($kategori_finansial) || empty($jenis_bibir) || empty($certainty) || empty($tone_kulit)) {
        return $this->response->setStatusCode(400)->setJSON(['error' => 'Data sesi tidak lengkap']);
    }

    if (!isset($normalize_jenis_bibir[$jenis_bibir])) {
        return $this->response->setStatusCode(400)->setJSON(['error' => 'Jenis bibir tidak valid']);
    }

    $target = [
        'kategori_finansial' => ((int) $kategori_finansial) - 1,
        'jenis_bibir' => $normalize_jenis_bibir[$jenis_bibir],
        'certainty' => (int) (((float) $certainty / 100) * 4),
        'tone_kulit' => $tone_kulit
    ];

    $rekomendasi_data = $this->kbs_m->getRekomendasiData($kategori_finansial, $jenis_bibir, $certainty, $tone_kulit);
    if (empty($rekomendasi_data)) {
        return $this->response->setJSON(['error' => 'Rekomendasi data tidak ditemukan']);
    }

    $matched_ids = array_column($rekomendasi_data, 'id');
    log_message('debug', 'Matched rekomendasi IDs: ' . json_encode($matched_ids));

    $alternative = $this->kbs_m->getProductsByRekomendasiIds($matched_ids);
    log_message('debug', 'Jumlah produk alternatif: ' . count($alternative));

    if (count($alternative) < 1) {
        $result['profile_matching'] = null;
        $result['products'] = [];
        return $this->response->setJSON($result);
    }

    $normalize_alternative = [];
    foreach ($alternative as $al) {
        log_message('debug', 'ID PRODUK: ' . $al['id'] . ', ID_JB: ' . $al['id_JB']);

        $ids = explode(',', $al['id_JB']);
        $valid_ids = array_keys($normalize_jenis_bibir);
        $intersect = array_intersect($ids, array_map('strval', $valid_ids));
        if (empty($intersect)) {
            log_message('debug', 'SKIPPED: ID_JB ' . $al['id_JB'] . ' tidak cocok normalize');
            continue;
        }

        $chosen_id = (int) array_shift($intersect);
        $kategori = mapKategoriFinansial((int) $al['harga']);

        $normalize_alternative[] = [
            'id' => $al['id'],
            'kategori_finansial' => $kategori - 1,
            'jenis_bibir' => $normalize_jenis_bibir[$chosen_id],
            'certainty' => (int) (((float) $al['certainty'] / 100) * 4),
            'tone_kulit' => (int) $al['tone_kulit']
        ];
    }

    log_message('debug', 'NORMALIZE ALTERNATIVE: ' . json_encode($normalize_alternative));

    $GAP = [];
    foreach ($normalize_alternative as $na) {
        $GAP[] = [
            'id' => $na['id'],
            'kategori_finansial' => max(min($na['kategori_finansial'] - $target['kategori_finansial'], 4), -4),
            'jenis_bibir' => max(min($na['jenis_bibir'] - $target['jenis_bibir'], 4), -4),
            'certainty' => max(min($na['certainty'] - $target['certainty'], 4), -4),
            'tone_kulit' => max(min($na['tone_kulit'] - $target['tone_kulit'], 4), -4)
        ];
    }
    log_message('debug', 'GAP RAW: ' . json_encode($GAP));

    $konversi = [];
    foreach ($GAP as $gap) {
        $konversi[] = [
            'id' => $gap['id'],
            'kategori_finansial' => $GAP_mapping[$gap['kategori_finansial']],
            'jenis_bibir' => $GAP_mapping[$gap['jenis_bibir']],
            'certainty' => $GAP_mapping[$gap['certainty']],
            'tone_kulit' => $GAP_mapping[$gap['tone_kulit']]
        ];
    }

    $faktor = [];
    foreach ($konversi as $konv) {
        $core_faktor = ($konv['kategori_finansial'] + $konv['certainty'] + $konv['tone_kulit']) / 3.0;
        $secondary_faktor = $konv['jenis_bibir'];

        $faktor[] = [
            'id' => $konv['id'],
            'NCF' => $core_faktor,
            'NSF' => $secondary_faktor
        ];
    }

    $final_NT = [];
    foreach ($faktor as $f) {
        $final_NT[] = [
            'id' => (int) $f['id'],
            'NT' => (0.66 * $f['NCF']) + (0.34 * $f['NSF'])
        ];
    }
    log_message('debug', 'ISI final_NT: ' . json_encode($final_NT));

    usort($final_NT, function($a, $b) {
        return $b['NT'] <=> $a['NT'];
    });

    $paling_mirip = $final_NT[0];
    log_message('debug', 'PALING MIRIP: ' . json_encode($paling_mirip));

    
    log_message('debug', 'ISI faktor: ' . json_encode($faktor));
    log_message('debug', 'ISI konversi: ' . json_encode($konversi));

    if (empty($final_NT)) {
        return $this->response->setStatusCode(500)->setJSON(['error' => 'Tidak ada hasil valid dari konversi GAP']);
    }

    $final_data = $this->sort_data($final_NT);
    $result['profile_matching'] = $final_data;

    $matched_ids = array_column($final_data, 'id');
    $matched_product_rows = $this->kbs_m->getProductIdsByRecommendationIds($matched_ids);
    $matched_product_ids = array_column($matched_product_rows, 'id_produk');

    log_message('debug', 'MATCHED PRODUCT IDS: ' . json_encode($matched_product_ids));

    $all_products = $this->kbs_m->getRecommendationProductsByIds($matched_product_ids);
    log_message('debug', 'ALL FINAL PRODUCTS (NO FILTER): ' . json_encode($all_products));

    $result['products'] = $all_products;

    log_message('debug', 'FINAL PRODUCTS TO FRONTEND (NO FILTER): ' . json_encode($result['products']));

    return $this->response->setJSON($result);
}

    public function KBSAlgorithm()
    {
        $session = session();

        $kategori_finansial = $session->get('SESS_KBS_LIPSTIK_KATEGORI_FINANSIAL');
        $tone_kulit = $session->get('SESS_KBS_LIPSTIK_TONE_KULIT');
        $jenis_bibir = $session->get('SESS_KBS_LIPSTIK_JENIS_BIBIR');

        if ($kategori_finansial == 4) {
            $result_products = $this->kbs_m->getProductsBySkin($jenis_bibir, 'DESC');
        } elseif ($kategori_finansial == 1) {
            $result_products = $this->kbs_m->getProductsBySkin($jenis_bibir, 'ASC');
        } else {
            $temp_products = $this->kbs_m->getProductsBySkin($jenis_bibir);
            $top_products = [];

            $range = [
                1 => [0, 50000],
                2 => [50001, 100000],
                3 => [100001, 200000],
                4 => [200001, PHP_INT_MAX],
            ];


            [$low, $high] = $range[$kategori_finansial];
            foreach ($temp_products as $tp) {
                if ($tp['harga'] >= $low && $tp['harga'] <= $high) {
                    $top_products[] = $tp;
                } else {
                    $ordinary_products[] = $tp;
                }
            }

            $result_products = array_merge($top_products, $ordinary_products ?? []);
        }

        return $this->response->setJSON($result_products);
    }

    public function product_button($action, $id)
    {
        $status = 'invalid';

        if ($action === "add") {
            $status = $this->kbs_m->addSingleProductScore($id) ? 'berhasil' : 'gagal';
        } elseif ($action === "remove") {
            $status = $this->kbs_m->removeSingleProductScore($id) ? 'berhasil' : 'gagal';
        }

        return $this->response->setJSON(['status' => $status]);
    }

    public function save_my_recommendation($str_id)
    {
        $products = array_filter(explode('_', $str_id));

        $session = session();
        $kategori_finansial = $session->get('SESS_KBS_LIPSTIK_KATEGORI_FINANSIAL');
        $certainty = $session->get('SESS_KBS_LIPSTIK_CERTAINTY');
        $jenis_bibir = $session->get('SESS_KBS_LIPSTIK_JENIS_BIBIR');
        $tone_kulit = (int) $session->get('SESS_KBS_LIPSTIK_TONE_KULIT');


        $rekomendasi_data = [
            'kategori_finansial' => $kategori_finansial,
            'jenis_bibir' => $jenis_bibir,
            'tone_kulit' => $tone_kulit,
            'certainty' => $certainty,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $rekomendasi_id = $this->kbs_m->saveRecommendation($rekomendasi_data);

        foreach ($products as $product) {
            $product_data = [
                'id_produk' => $product,
                'id_rekomendasi' => $rekomendasi_id,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $result = $this->kbs_m->saveProductRecommendation($product_data);

            if (!$result) {
                return $this->response->setJSON(['status' => 'gagal']);
            }
        }

        return $this->response->setJSON(['status' => 'berhasil']);
    }

    public function submit_sus_feedback()
    {
        helper('text');
        $data = $this->request->getPost();
        $feedback_id = random_string('alnum', 15);

        foreach ($data as $k => $v) {
            $kunci = explode('_', $k);
            $temp = [
                'feedback_id' => $feedback_id,
                'id_soal' => $kunci[1],
                'jawaban' => $v
            ];

            if (!$this->kbs_m->submitSusAnswer($temp)) {
                return $this->response->setJSON(['status' => 'gagal']);
            }
        }
        session()->set('has_submit', true);
        return redirect()->to('User/Jenis_Bibir/rekomendasi')->with('show_csat', true);

    }

    public function submit_csat_feedback()
    {
        $userId = session()->get('user_id') ?? 0;
        $rating = $this->request->getPost('csat_1');

        if ($rating) {
            $data = [
                'user_id' => $userId,
                'question_id' => 1,
                'rating' => $rating,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $this->kbs_m->saveCsatFeedback($data);
        }
        return redirect()->to('User/Jenis_Bibir/rekomendasi')->with('message', 'CSAT Feedback berhasil disimpan!');
    }


}
