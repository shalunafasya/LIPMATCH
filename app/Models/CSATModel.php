<?php

namespace App\Models;

use CodeIgniter\Model;

class CSATModel extends Model
{
    protected $table = 'csat_feedback';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'question_id', 'rating', 'created_at', 'updated_at'];
    protected $db;

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }

    public function getAverageCSAT()
    {
        $builder = $this->db->table($this->table);
        $total = $builder->countAll();
        $positive = $builder->whereIn('rating', [4, 5])->countAllResults();

        if ($total === 0) {
            return 0;
        }

        $csat = ($positive / $total) * 100;

        return round($csat, 2); 
    }

    public function getAllFeedback()
    {
        return $this->db->table($this->table)->get()->getResultArray();
    }

    public function resetCSAT()
    {
        return $this->db->table($this->table)->truncate();
    }
}
