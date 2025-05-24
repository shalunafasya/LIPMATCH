<?php

namespace App\Models\User;

use CodeIgniter\Model;

class JawabanBayes_model extends Model
{
    protected $table = 'jawaban_bayes';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_pertanyaan', 'nomor_soal', 'jawaban', 'created_at', 'updated_At'];
}

