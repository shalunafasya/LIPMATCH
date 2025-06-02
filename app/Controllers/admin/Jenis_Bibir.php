<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Admin\JB_model;

class Jenis_Bibir extends BaseController
{
    protected $jbModel;

    public function __construct()
    {
        helper('form');
        $this->jbModel = new JB_model();
    }

    public function index()
    {
        $data = [
            'List_JB' => $this->jbModel->tampildata(),
        ];

        return view('admin/admin_sidebar')
            . view('admin/jenis_bibir/index_JB', $data)
            . view('admin/admin_footer');
    }

    public function tambah_data()
    {
        return view('admin/admin_sidebar')
            . view('admin/jenis_bibir/tambah_dataJB')
            . view('admin/admin_footer');
    }

    public function proses_tambah_data()
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'jenis_bibir' => 'required|min_length[3]',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->to('/admin/jenis_bibir/tambah')
                ->withInput()
                ->with('errors', $validation->getErrors());
        }

        $jenis_bibir = $this->request->getPost('jenis_bibir');
        $data = [
            'nama_JB' => $jenis_bibir
        ];

        $this->jbModel->tambah_data($data);
        return redirect()->to('/admin/jenis_bibir');
    }

    public function hapusdata($id_JB = null)
    {
        if ($id_JB) {
            $this->jbModel->hapusdata($id_JB);
        }
        return redirect()->to('/admin/jenis_bibir');
    }

    public function editdata($id_JB = null)
    {
        if (!$id_JB) {
            return redirect()->to('/admin/jenis_bibir');
        }

        $data = [
            'dataJB' => $this->jbModel->get_by_id($id_JB)
        ];

        return view('admin/admin_sidebar')
            . view('admin/jenis_bibir/editJB', $data)
            . view('admin/admin_footer');
    }

    public function proses_editdata($id_JB = null)
    {
        if (!$id_JB) {
            return redirect()->to('/admin/jenis_bibir');
        }

        $jenis_bibir = $this->request->getPost('jenis_bibir');

        if (empty($jenis_bibir)) {
            return redirect()->to('/admin/jenis_bibir/editdata/' . $id_JB)
                ->with('error', 'Jenis Bibir tidak boleh kosong')
                ->withInput();
        }
        $data = [
            'nama_JB' => $jenis_bibir
        ];

        $this->jbModel->editdata($id_JB, $data);
        return redirect()->to('/admin/jenis_bibir');
    }
}
