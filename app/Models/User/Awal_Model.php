<?php

namespace App\Models\User;

use CodeIgniter\Model;

class Awal_Model extends Model
{
    protected $table = 'data_pengguna'; 
    protected $primaryKey = 'id'; 
    protected $allowedFields = ['nama']; 

    public function simpan_nama($data)
    {
        return $this->insert($data);
    }

    public function cek_tone($id_tk)
    {
        return $this->db->table('tone_kulit')
                        ->select('tone_kulit')
                        ->where('id_tk', $id_tk)
                        ->get()
                        ->getRow(); 
    }

    public function getToneKulit()
    {
        return $this->db->table('tone_kulit')->get()->getResult();
    }
}
