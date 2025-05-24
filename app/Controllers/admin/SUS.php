<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SUSModel;

class SUS extends BaseController
{
    protected $m_sus;

    public function __construct()
    {
        $this->m_sus = new SUSModel();
    }

    public function index()
    {
        $data = [
            'skor_SUS' => $this->m_sus->getSkor(),
            'soal_jawaban' => $this->m_sus->getSoalJawaban()
        ];

        return view('admin/admin_sidebar')
            . view('admin/sus/index', $data)
            . view('admin/admin_footer');
    }
}
