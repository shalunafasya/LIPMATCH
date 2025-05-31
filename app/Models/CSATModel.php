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
        $result = $this->db->table($this->table)
            ->selectAvg('rating', 'average_rating')
            ->get()
            ->getRow();

        return $result ? $result->average_rating : 0;
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
