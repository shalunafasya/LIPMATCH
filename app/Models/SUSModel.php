<?php

namespace App\Models;

use CodeIgniter\Model;

class SUSModel extends Model
{
    protected $db;

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect(); 
    }

    public function getSkor()
    {
        $query = "SELECT feedback_id FROM sus_feedback GROUP BY feedback_id";
        $feedbacks = $this->db->query($query)->getResultArray();

        $totalSkor = 0;

        foreach ($feedbacks as $feedback) {
            $skors = $this->db->table('sus_feedback')
                              ->where('feedback_id', $feedback['feedback_id'])
                              ->get()
                              ->getResultArray();

            foreach ($skors as $skor) {
                if ($skor['id_soal'] % 2 == 0) {
                    $totalSkor += (int)$skor['jawaban'] - 5;
                } else {
                    $totalSkor += (int)$skor['jawaban'] - 1;
                }
            }
        }

        return count($feedbacks) > 0 ? (float) $totalSkor / count($feedbacks) : 0;
    }

    public function getSoalJawaban()
    {
        $query = "
            SELECT 
                sus_feedback.id, 
                sus_feedback.feedback_id, 
                sus_pertanyaan.soal, 
                sus_feedback.jawaban 
            FROM 
                sus_feedback 
            JOIN 
                sus_pertanyaan 
            ON 
                sus_feedback.id_soal = sus_pertanyaan.id
        ";

        return $this->db->query($query)->getResultArray();
    }
}
