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
        // Validasi input
        $validation = \Config\Services::validation();
        $validation->setRules([
            'jenis_bibir' => 'required|min_length[3]',  // Pastikan data tidak kosong dan panjang minimal 3 karakter
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            // Jika validasi gagal, kembalikan ke form tambah data dengan pesan error
            return redirect()->to('/admin/jenis_bibir/tambah')
                ->withInput()
                ->with('errors', $validation->getErrors());
        }

        // Ambil data dari form
        $jenis_bibir = $this->request->getPost('jenis_bibir');

        // Siapkan data untuk dimasukkan ke database
        $data = [
            'nama_JB' => $jenis_bibir
        ];

        // Simpan data ke database
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

        // Siapkan data untuk update
        $data = [
            'nama_JB' => $jenis_bibir
        ];

        $this->jbModel->editdata($id_JB, $data);
        return redirect()->to('/admin/jenis_bibir');
    }
}
