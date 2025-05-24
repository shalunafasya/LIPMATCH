<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class Produk_model extends Model
{
    protected $table = 'produk';
    protected $primaryKey = 'id_produk';
    protected $allowedFields = ['jenis_lipstik', 'merk_produk', 'nama_produk', 'id_JB', 'gambar', 'harga', 'id_tk']; 
    protected $useTimestamps = false;

    public function tampildata()
{
    return $this->select('produk.*, jenis_lipstik.jenis_lipstik')
                ->join('jenis_lipstik', 'produk.jenis_lipstik = jenis_lipstik.id_jl')
                ->findAll();
}

    public function tambah_data($data)
    {
        return $this->insert($data);
    }

    public function hapusdata($id_produk)
    {
        return $this->delete($id_produk);
    }

    public function get_by_id($id_produk)
    {
        return $this->where('id_produk', $id_produk)->findAll();
    }

    public function editdata($id_produk, $data)
    {
        return $this->update($id_produk, $data);
    }
}
