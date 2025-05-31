<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CSATModel;

class CSAT extends BaseController
{
    protected $m_csat;

    public function __construct()
    {
        $this->m_csat = new CSATModel();
    }

    public function index()
    {
        $data = [
            'skor_CSAT' => $this->m_csat->getAverageCSAT(),
            'csat_feedback' => $this->m_csat->getAllFeedback()
        ];

        return view('admin/admin_sidebar')
            . view('admin/csat/index', $data)
            . view('admin/admin_footer');
    }

    public function reset()
    {
        $this->m_csat->resetCSAT();
        return redirect()->to('/admin/CSAT')->with('message', 'Semua data CSAT berhasil direset!');
    }
}
