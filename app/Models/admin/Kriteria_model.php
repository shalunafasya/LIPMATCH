<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class Kriteria_model extends Model
{
    protected $table = 'kriteria';
    protected $primaryKey = 'id_kriteria';
    protected $allowedFields = ['kriteria', 'deskripsi', 'kriteria']; 

    public function tampildata()
    {
        return $this->findAll(); 
    }

    public function tambah_data($data)
    {
        return $this->insert($data); 
    }

    public function hapusdata($id_kriteria)
    {
        return $this->delete($id_kriteria); 
    }

    public function get_by_id($id_kriteria)
    {
        return $this->find($id_kriteria); 
    }

    public function editdata($id_kriteria, $data)
    {
        return $this->update($id_kriteria, $data); 
    }
}
