<?php

namespace App\Models\User;

use CodeIgniter\Model;

class KondisiBibir_model extends Model
{
    protected $table = 'kondisi_bibir';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'id_jawaban',
        'normal',
        'kering',
        'gelap',
        'kombinasi',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
