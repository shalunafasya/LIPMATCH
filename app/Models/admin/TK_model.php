<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class TK_model extends Model
{
    protected $table = 'tone_kulit';
    protected $primaryKey = 'id_tk';
    protected $allowedFields = ['jenis_lipstik', 'merk_produk', 'tone_kulit'];

    public function tampildata()
    {
        return $this->findAll();
    }

    public function tambah_data($data)
    {
        return $this->insert($data);
    }

    public function hapusdata($id_tk)
    {
        return $this->delete($id_tk);
    }

    public function get_by_id($id_tk)
    {
        return $this->find($id_tk);
    }

    public function editdata($id_tk, $data)
    {
        return $this->update($id_tk, $data);
    }
}
