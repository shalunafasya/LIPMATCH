<?php

namespace App\Models;

use CodeIgniter\Model;

class KBSModel extends Model
{
    protected $table = 'produk';
    protected $primaryKey = 'id_produk';

    protected $allowedFields = [
        'id_produk',
        'jenis_lipstik',
        'merk_produk',
        'nama_produk',
        'harga',
        'rekomendasi',
        'id_JB',
        'id_tk',
        'gambar',
        'created_at',
        'updated_at'
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
            $builder->groupStart()
                ->where('tone_kulit', $tone_kulit)
                ->orWhere('tone_kulit', 0)
                ->groupEnd();
        }

        return $builder->get()->getResultArray();
    }

    public function getRecommendationProduct($id_rekomendasi)
    {
        $builder = $this->db->table('rekomendasi_produk');
        $builder->select('produk.id_produk, jenis_lipstik.jenis_lipstik as jenis_lipstik, produk.merk_produk, produk.nama_produk, produk.harga, produk.rekomendasi, produk.id_tk')
            ->join('produk', 'produk.id_produk = rekomendasi_produk.id_produk')
            ->join('jenis_lipstik', 'jenis_lipstik.id_jl = produk.jenis_lipstik')
            ->join('jenis_bibir', 'produk.id_JB = jenis_bibir.id_JB')
            ->where('rekomendasi_produk.id_rekomendasi', $id_rekomendasi)
            ->orderBy('produk.rekomendasi', 'DESC');

        return $builder->get()->getResultArray();
    }

    public function getAllFavoritedProductIds()
    {
        return $this->db->table('rekomendasi_produk')
            ->select('id_produk')
            ->groupBy('id_produk')
            ->having('COUNT(*) >=', 5)
            ->get()
            ->getResultArray();

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

    public function getRecommendationProductsByIds($product_ids)
    {
        if (empty($product_ids)) {
            return [];
        }

        $builder = $this->db->table('produk');
        $builder->select('produk.id_produk, jenis_lipstik.jenis_lipstik as jenis_lipstik, produk.merk_produk, produk.nama_produk, produk.harga, produk.rekomendasi, produk.id_tk')
            ->join('jenis_lipstik', 'jenis_lipstik.id_jl = produk.jenis_lipstik')
            ->join('jenis_bibir', 'produk.id_JB = jenis_bibir.id_JB')
            ->whereIn('produk.id_produk', $product_ids)
            ->orderBy('produk.rekomendasi', 'DESC');

        return $builder->get()->getResultArray();
    }

    public function getProductIdsByRecommendationIds($recommendation_ids)
    {
        return $this->db->table('rekomendasi_produk')
            ->select('id_produk')
            ->whereIn('id_rekomendasi', $recommendation_ids)
            ->get()
            ->getResultArray();
    }

    public function getProdukByIds($ids = [])
    {
        if (empty($ids)) return [];

        return $this->db->table('produk')
            ->select('produk.*, jenis_lipstik.id_jl, jenis_lipstik.jenis_lipstik')
            ->join('jenis_lipstik', 'jenis_lipstik.id_jl = produk.jenis_lipstik')
            ->whereIn('produk.id_produk', $ids)
            ->orderBy('produk.rekomendasi', 'DESC')
            ->orderBy('produk.harga', 'ASC')
            ->get()
            ->getResult();
    }

    public function getRekomendasiData($kategori_finansial, $jenis_bibir, $certainty, $tone_kulit) {
        return $this->db->table('rekomendasi')
            ->where('kategori_finansial', $kategori_finansial)
            ->where('jenis_bibir', $jenis_bibir)
            ->where('certainty', $certainty)
            ->where('tone_kulit', $tone_kulit)
            ->get()
            ->getResultArray();
    }

    public function getProductsByRekomendasi($id_rekomendasi) {
        return $this->db->table('rekomendasi_produk')
            ->join('produk', 'produk.id_produk = rekomendasi_produk.id_produk')
            ->where('id_rekomendasi', $id_rekomendasi)
            ->get()
            ->getResultArray();
    }

    public function getProductsByRekomendasiIds($ids)
{
    return $this->db->table('rekomendasi_produk')
        ->select('produk.*, rekomendasi.*, rekomendasi_produk.id_rekomendasi')
        ->join('produk', 'produk.id_produk = rekomendasi_produk.id_produk')
        ->join('rekomendasi', 'rekomendasi.id = rekomendasi_produk.id_rekomendasi')
        ->whereIn('rekomendasi_produk.id_rekomendasi', $ids)
        ->get()
        ->getResultArray();
}



}
