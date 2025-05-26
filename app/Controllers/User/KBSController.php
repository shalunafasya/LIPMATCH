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
    
    $session = session();
    $result = [];

    $GAP_mapping = [
        0 => 5.0, 1 => 4.5, -1 => 4.0, 2 => 3.5,
        -2 => 3.0, 3 => 2.5, -3 => 2.0, 4 => 1.5, -4 => 1.0
    ];

    $normalize_jenis_bibir = [1 => 1, 2 => 2, 3 => 3, 4 => 4];

    $kategori_finansial = $session->get('SESS_KBS_LIPSTIK_KATEGORI_FINANSIAL');
    $jenis_bibir = $session->get('SESS_KBS_LIPSTIK_JENIS_BIBIR');
    $certainty = $session->get('SESS_KBS_LIPSTIK_CERTAINTY');
    $tone_kulit = (int) $session->get('sess_tone_bibir');

    if (
        empty($kategori_finansial) || empty($jenis_bibir) ||
        empty($certainty) || empty($tone_kulit)
    ) {
        return $this->response->setStatusCode(400)->setJSON(['error' => 'Data sesi tidak lengkap']);
    }

    if (!isset($normalize_jenis_bibir[$jenis_bibir])) {
        return $this->response->setStatusCode(400)->setJSON(['error' => 'Jenis bibir tidak valid']);
    }

    $target = [
        'kategori_finansial' => ((int) $kategori_finansial) - 1,
        'jenis_bibir' => $normalize_jenis_bibir[$jenis_bibir],
        'certainty' => (int)(((float) $certainty / 100) * 4)
    ];

    $alternative = $this->kbs_m->getAllAlternative($jenis_bibir, $tone_kulit);

    if (count($alternative) < 5) {
        $result['profile_matching'] = null;
        $result['products'] = $this->kbs_m->getProductsBySkin($jenis_bibir, 'ASC');
        return $this->response->setJSON($result);
    }

    $normalize_alternative = [];
    foreach ($alternative as $al) {
        if (!isset($normalize_jenis_bibir[$al['jenis_bibir']])) continue;

        $normalize_alternative[] = [
            'id' => $al['id'],
            'kategori_finansial' => ((int) $al['kategori_finansial']) - 1,
            'jenis_bibir' => $normalize_jenis_bibir[$al['jenis_bibir']],
            'certainty' => (int)(((float) $al['certainty'] / 100) * 4)
        ];
    }

    $GAP = [];
    foreach ($normalize_alternative as $na) {
        $GAP[] = [
            'id' => $na['id'],
            'kategori_finansial' => $na['kategori_finansial'] - $target['kategori_finansial'],
            'jenis_bibir' => $na['jenis_bibir'] - $target['jenis_bibir'],
            'certainty' => $na['certainty'] - $target['certainty']
        ];
    }

    $konversi = [];
    foreach ($GAP as $gap) {
        if (
            !isset($GAP_mapping[$gap['kategori_finansial']]) ||
            !isset($GAP_mapping[$gap['jenis_bibir']]) ||
            !isset($GAP_mapping[$gap['certainty']])
        ) {
            continue;
        }

        $konversi[] = [
            'id' => $gap['id'],
            'kategori_finansial' => $GAP_mapping[$gap['kategori_finansial']],
            'jenis_bibir' => $GAP_mapping[$gap['jenis_bibir']],
            'certainty' => $GAP_mapping[$gap['certainty']]
        ];
    }

    $faktor = [];
    foreach ($konversi as $konv) {
        $core_faktor = ($konv['kategori_finansial'] + $konv['certainty']) / 2.0;
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

    if (empty($final_NT)) {
        return $this->response->setStatusCode(500)->setJSON(['error' => 'Tidak ada hasil valid dari konversi GAP']);
    }

    $final_data = $this->sort_data($final_NT);

    $result['profile_matching'] = $final_data;
    $result['products'] = $this->kbs_m->getRecommendationProduct($final_data[0]['id']);
    $result['products'] = array_filter($result['products'], function ($product) use ($tone_kulit) {
        return $product['id_tk'] == $tone_kulit;
    });

    return $this->response->setJSON($result);
}

    public function KBSAlgorithm()
    {
        $session = session();

        $kategori_finansial = $session->get('SESS_KBS_LIPSTIK_KATEGORI_FINANSIAL');
        $jenis_bibir = $session->get('SESS_KBS_LIPSTIK_JENIS_BIBIR');

        if ($kategori_finansial == 5) {
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
                4 => [200001, PHP_INT_MAX], // biar benar-benar ke atas tanpa batas
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

        $rekomendasi_data = [
            'kategori_finansial' => $kategori_finansial,
            'jenis_bibir'        => $jenis_bibir,
            'certainty'          => $certainty,
            'created_at'         => date('Y-m-d H:i:s'),
            'updated_at'         => date('Y-m-d H:i:s')
        ];

        $rekomendasi_id = $this->kbs_m->saveRecommendation($rekomendasi_data);

        foreach ($products as $product) {
            $product_data = [
                'id_produk'      => $product,
                'id_rekomendasi' => $rekomendasi_id,
                'created_at'     => date('Y-m-d H:i:s'),
                'updated_at'     => date('Y-m-d H:i:s')
            ];

            $result = $this->kbs_m->saveProductRecommendation($product_data);

            if (!$result) {
                return $this->response->setJSON(['status' => 'gagal']);
            }
        }

        return $this->response->setJSON(['status' => 'berhasil']);
    }

    public function submit_feedback()
    {
        helper('text');
        $data = $this->request->getPost();
        $feedback_id = random_string('alnum', 15);

        foreach ($data as $k => $v) {
            $kunci = explode('_', $k);
            $temp = [
                'feedback_id' => $feedback_id,
                'id_soal'     => $kunci[1],
                'jawaban'     => $v
            ];

            if (!$this->kbs_m->submitSusAnswer($temp)) {
                return $this->response->setJSON(['status' => 'gagal']);
            }
        }

        return redirect()->to('User/Jenis_Bibir/rekomendasi/true');
    }
}
