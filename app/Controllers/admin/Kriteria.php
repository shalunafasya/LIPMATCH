<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Admin\Kriteria_model;

class Kriteria extends BaseController
{
    protected $kriteriaModel;

    public function __construct()
    {
        $this->kriteriaModel = new Kriteria_model();
    }

    public function index()
    {
        $data = [
            'List_Kriteria' => $this->kriteriaModel->tampildata()
        ];

        return view('admin/admin_sidebar')
            . view('admin/Kriteria/index_Kriteria', $data)
            . view('admin/admin_footer');
    }

    public function tambah_data()
    {
        return view('admin/admin_sidebar')
            . view('admin/Kriteria/tambah_data')
            . view('admin/admin_footer');
    }

    public function proses_tambah_data()
    {
        $kriteria = $this->request->getPost('kriteria');

        $data = [
            'kriteria' => $kriteria
        ];

        $this->kriteriaModel->tambah_data($data);
        return redirect()->to('/admin/kriteria');
    }

    public function hapusdata($id_kriteria = null)
    {
        if ($id_kriteria) {
            $this->kriteriaModel->hapusdata($id_kriteria);
        }
        return redirect()->to('/admin/kriteria');
    }

    public function editdata($id_kriteria = null)
    {
        if (!$id_kriteria) {
            return redirect()->to('/admin/kriteria');
        }

        $data = [
            'data_kriteria' => $this->kriteriaModel->get_by_id($id_kriteria)
        ];

        return view('admin/admin_sidebar')
            . view('admin/Kriteria/editkriteria', $data)
            . view('admin/admin_footer');
    }

    public function proses_edit_data($id_kriteria = null)
    {
        if (!$id_kriteria) {
            return redirect()->to('/admin/kriteria');
        }

        $kriteria = $this->request->getPost('kriteria');

        $data = [
            'kriteria' => $kriteria
        ];

        $this->kriteriaModel->editdata($id_kriteria, $data);
        return redirect()->to('/admin/kriteria');
    }
}
