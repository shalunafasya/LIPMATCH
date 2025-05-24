<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Admin\JL_model;

class Jenis_lipstik extends BaseController
{
    protected $jlModel;

    public function __construct()
    {
        $this->jlModel = new JL_model(); // Menggunakan CI4 model
    }

    public function index()
    {
        $data = [
            'List_JL' => $this->jlModel->tampildata()
        ];

        return view('admin/admin_sidebar')
            . view('admin/jenis_lipstik/index_JL', $data)
            . view('admin/admin_footer');
    }

    public function tambah_dataJL()
    {
        return view('admin/admin_sidebar')
            . view('admin/jenis_lipstik/tambah_dataJL')
            . view('admin/admin_footer');
    }

    public function proses_tambah_data()
    {
        $jenis_lipstik = $this->request->getPost('jenis_lipstik');

        $data = [
            'jenis_lipstik' => $jenis_lipstik
        ];

        $this->jlModel->tambah_dataJL($data); 
        return redirect()->to('/admin/jenis_lipstik');
    }

    public function hapusdata($id_jl = null)
    {
        if ($id_jl) {
            $this->jlModel->hapusdata($id_jl);
        }
        return redirect()->to('/admin/jenis_lipstik');
    }

    public function editdata($id_jl = null)
    {
        if (!$id_jl) {
            return redirect()->to('/admin/jenis_lipstik');
        }

        $data = [
            'data_jenis_lipstik' => $this->jlModel->get_by_id($id_jl)
        ];

        return view('admin/admin_sidebar')
            . view('admin/jenis_lipstik/editJL', $data)
            . view('admin/admin_footer');
    }

    public function proses_edit_data($id_jl = null)
    {
        if (!$id_jl) {
            return redirect()->to('/admin/jenis_lipstik');
        }

        $jenis_lipstik = $this->request->getPost('jenis_lipstik');

        $data = [
            'jenis_lipstik' => $jenis_lipstik
        ];

        $this->jlModel->editdata($id_jl, $data);
        return redirect()->to('/admin/jenis_lipstik');
    }
}
