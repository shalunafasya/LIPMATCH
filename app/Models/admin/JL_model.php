<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class JL_model extends Model
{
    protected $table = 'jenis_lipstik';
    protected $primaryKey = 'id_jl';
    protected $allowedFields = ['jenis_lipstik', 'merk_produk'];

    public function tampildata()
    {
        return $this->findAll();
    }

    public function tambah_dataJL($data)
    {
        return $this->insert($data);
    }

    public function hapusdata($id_jl)
    {
        return $this->delete($id_jl);
    }

    public function get_by_id($id_jl)
    {
        return $this->find($id_jl);
    }

    public function editdata($id_jl, $data)
    {
        return $this->update($id_jl, $data);
    }
}
