<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class JB_model extends Model
{
    protected $table = 'jenis_bibir';
    protected $primaryKey = 'id_JB';
    protected $allowedFields = ['jenis_lipstik', 'merk_produk', 'nama_JB'];

    public function tampildata()
    {
        return $this->findAll();
    }

    public function tambah_data($data)
    {
        return $this->insert($data);
    }

    public function hapusdata($id_JB)
    {
        return $this->delete($id_JB);
    }

    public function get_by_id($id_JB)
    {
        return $this->find($id_JB);
    }

    public function editdata($id_JB, $data)
    {
        return $this->update($id_JB, $data);
    }
}
