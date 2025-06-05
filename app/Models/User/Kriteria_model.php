<?php

namespace App\Models\User;

use CodeIgniter\Model;

class Kriteria_model extends Model
{
    protected $table = 'kriteria';
    protected $primaryKey = 'id_kriteria';
    protected $allowedFields = ['keterangan', 'bobot'];

    public function cek_bobot($keterangan)
    {
        return $this->db->table('nilai_bobot')
            ->select('bobot')
            ->where('keterangan', $keterangan)
            ->get()
            ->getResult();
    }

    public function tampil()
    {
        return $this->findAll();
    }

    public function produk_by_jb_and_tone($id_JB, $id_tk)
    {
        return $this->db->table('produk')
            ->select('produk.id_produk, jenis_lipstik.jenis_lipstik as jenis_lipstik, tone_kulit.tone_kulit as tone_kulit, produk.merk_produk as merk_produk, produk.nama_produk as nama_produk, produk.harga, produk.rekomendasi, gambar')
            ->join('jenis_lipstik', 'jenis_lipstik.id_jl = produk.jenis_lipstik')
            ->join('jenis_bibir', 'produk.id_JB = jenis_bibir.id_JB')
            ->join('tone_kulit', 'FIND_IN_SET(tone_kulit.id_tk, produk.id_tk) > 0')
            ->where("FIND_IN_SET('$id_JB', produk.id_JB) >", 0)
            ->where("FIND_IN_SET('$id_tk', produk.id_tk) >", 0)
            ->groupBy('produk.id_produk')
            ->orderBy('produk.rekomendasi', 'DESC')
            ->orderBy('produk.harga', 'ASC')
            ->get()
            ->getResult();
    }

    public function produk_by_jb_and_filter_tone($id_JB, $id_filter = [], $id_tk = null)
    {
        $builder = $this->db->table('produk');
        $builder->select('produk.id_produk, jenis_lipstik.jenis_lipstik as jenis_lipstik, tone_kulit.tone_kulit as tone_kulit, produk.merk_produk, produk.nama_produk, produk.harga, produk.rekomendasi, produk.gambar');
        $builder->join('jenis_lipstik', 'jenis_lipstik.id_jl = produk.jenis_lipstik');
        $builder->join('tone_kulit', 'produk.id_tk = tone_kulit.id_tk');
        $builder->join('jenis_bibir', 'FIND_IN_SET(jenis_bibir.id_JB, produk.id_JB) > 0');
        $builder->where('produk.id_JB', $id_JB);

        if (!is_null($id_tk)) {
            $builder->where("FIND_IN_SET('$id_tk', produk.id_tk) >", 0);
        }

        if (!empty($id_filter) && is_array($id_filter)) {
            $builder->groupStart();
            foreach ($id_filter as $index => $val) {
                $index == 0
                    ? $builder->where('produk.jenis_lipstik', $val)
                    : $builder->orWhere('produk.jenis_lipstik', $val);
            }
            $builder->groupEnd();
        }

        $builder->orderBy('produk.rekomendasi', 'DESC')
            ->orderBy('produk.harga', 'ASC');
        return $builder->get()->getResult();
    }


    public function all_produk()
    {
        return $this->db->table('produk')
            ->select('produk.id_produk, jenis_lipstik.jenis_lipstik as jenis_lipstik, tone_kulit.tone_kulit as tone_kulit, produk.merk_produk as merk_produk, produk.nama_produk as nama_produk, produk.harga, produk.rekomendasi, produk.gambar')
            ->join('jenis_lipstik', 'jenis_lipstik.id_jl = produk.jenis_lipstik')
            ->join('jenis_bibir', 'produk.id_JB = jenis_bibir.id_JB')
            ->join('tone_kulit', 'produk.id_tk = tone_kulit.id_tk')
            ->orderBy('produk.rekomendasi', 'DESC')
            ->get()
            ->getResult();
    }

}
