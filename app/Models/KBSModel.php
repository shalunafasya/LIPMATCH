<?php

namespace App\Models;

use CodeIgniter\Model;

class KBSModel extends Model
{
    protected $table      = 'produk';
    protected $primaryKey = 'id_produk';

    protected $allowedFields = [
        'id_produk', 'jenis_lipstik', 'merk_produk', 'nama_produk',
        'harga', 'rekomendasi', 'id_JB', 'id_tk', 'gambar',
        'created_at', 'updated_at'
    ];

    public function getProductsBySkin($id_JB, $sort = null)
    {
        $builder = $this->db->table('produk');
        $builder->select('produk.id_produk, jenis_lipstik.jenis_lipstik as jenis_lipstik, produk.merk_produk, produk.nama_produk, produk.harga, produk.rekomendasi')
            ->join('jenis_lipstik', 'jenis_lipstik.id_jl = produk.jenis_lipstik')
            ->join('jenis_bibir', 'produk.id_JB = jenis_bibir.id_JB')
            ->where('produk.id_JB', $id_JB);

        if ($sort) {
            $builder->orderBy('produk.rekomendasi', 'DESC');
            $builder->orderBy('produk.harga', $sort);
        }

        return $builder->get()->getResultArray();
    }

    public function getAllAlternative($jenis_bibir, $tone_kulit = null)
    {
        $builder = $this->db->table('rekomendasi');

        if (!is_null($jenis_bibir)) {
            $builder->where('jenis_bibir', $jenis_bibir);
        }

        if (!is_null($tone_kulit)) {
            $builder->where('tone_kulit', $tone_kulit);
        }

        return $builder->get()->getResultArray();
    }

    public function getRecommendationProduct($id_rekomendasi)
    {
        $builder = $this->db->table('rekomendasi_produk');
        $rekomendasi_produk = $builder->where('id_rekomendasi', $id_rekomendasi)->get()->getResultArray();

        $id_JB = session()->get('SESS_KBS_SKINCARE_JENIS_KULIT');

        $builder = $this->db->table('produk');
        $builder->select('produk.id_produk, jenis_lipstik.jenis_lipstik as jenis_lipstik, produk.merk_produk, produk.nama_produk, produk.harga, produk.rekomendasi')
            ->join('jenis_lipstik', 'jenis_lipstik.id_jl = produk.jenis_lipstik')
            ->join('jenis_bibir', 'produk.id_JB = jenis_bibir.id_JB')
            ->where('produk.id_JB', $id_JB)
            ->orderBy('produk.rekomendasi', 'DESC');

        $temp_produk = $builder->get()->getResultArray();
        $data_produk = [];

        foreach ($rekomendasi_produk as $rekomen) {
            foreach ($temp_produk as $tp) {
                if ($rekomen['id_produk'] == $tp['id_produk']) {
                    $data_produk[] = $tp;
                    break;
                }
            }
        }

        foreach ($temp_produk as $produk) {
            $exist = false;
            foreach ($data_produk as $dt) {
                if ($dt['id_produk'] == $produk['id_produk']) {
                    $exist = true;
                    break;
                }
            }

            if (!$exist) {
                $data_produk[] = $produk;
            }
        }

        return $data_produk;
    }

    public function saveRecommendation($data)
    {
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->table('rekomendasi')->insert($data);
        return $this->db->insertID();
    }

    public function saveProductRecommendation($data)
    {
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->db->table('rekomendasi_produk')->insert($data);
    }

    public function addSingleProductScore($id_produk)
    {
        $builder = $this->db->table('produk');
        $current = $builder->where('id_produk', $id_produk)->get()->getRowArray();
        $score = $current['rekomendasi'] + 1;

        $builder->set('rekomendasi', $score)->where('id_produk', $id_produk)->update();
        return $this->db->affectedRows();
    }

    public function removeSingleProductScore($id_produk)
    {
        $builder = $this->db->table('produk');
        $current = $builder->where('id_produk', $id_produk)->get()->getRowArray();
        $score = max(0, $current['rekomendasi'] - 1);

        $builder->set('rekomendasi', $score)->where('id_produk', $id_produk)->update();
        return $this->db->affectedRows();
    }

    public function addProductScore($products)
    {
        foreach ($products as $product) {
            $builder = $this->db->table('produk');
            $current = $builder->where('id_produk', $product->id_produk)->get()->getRowArray();
            $score = $current['rekomendasi'] + 1;

            $builder->set('rekomendasi', $score)->where('id_produk', $product->id_produk)->update();
        }
    }

    public function getAllFilter()
    {
        return $this->db->table('jenis_lipstik')->get()->getResultArray();
    }

    public function getSusQuestion()
    {
        return $this->db->table('sus_pertanyaan')->get()->getResultArray();
    }

    public function submitSusAnswer($data)
    {
        return $this->db->table('sus_feedback')->insert($data);
    }

    public function saveCsatFeedback($data)
    {
        return $this->db->table('csat_feedback')->insert($data);
    }

}
