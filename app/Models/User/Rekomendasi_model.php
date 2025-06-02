<?php

namespace App\Models\User;

use CodeIgniter\Model;

class Rekomendasi_model extends Model
{
    protected $table = 'produk';
    protected $primaryKey = 'id_produk';
    protected $allowedFields = ['jenis_lipstik', 'merk_produk', 'nama_produk', 'rekomendasi'];

    public function tampil_produk()
    {
        return $this->db->table('produk')
            ->select('jenis_lipstik.jenis_lipstik as jenis_lipstik, produk.merk_produk as merk_produk, produk.nama_produk as nama_produk, produk.rekomendasi, tone_kulit.tone_kulit as tone_kulit')
            ->join('jenis_lipstik', 'jenis_lipstik.id_jl = produk.jenis_lipstik')
            ->join('tone_kulit', 'produk.id_tk = tone_kulit.id_tk')
            ->get()
            ->getResult();
    }

    public function tampil_produk_byJB($JB)
    {
        return $this->db->table('produk')
            ->select('jenis_lipstik.jenis_lipstik as jenis_lipstik, produk.merk_produk as merk_produk, produk.nama_produk as nama_produk, produk.rekomendasi')
            ->join('jenis_lipstik', 'jenis_lipstik.id_jl = produk.jenis_lipstik')
            ->join('jenis_bibir', 'produk.id_JB = jenis_bibir.id_JB')
            ->where('jenis_bibir.nama_JB', $JB)
            ->get()
            ->getResult();
    }
}
