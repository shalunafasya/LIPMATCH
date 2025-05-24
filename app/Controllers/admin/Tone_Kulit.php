<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Admin\TK_model;

class Tone_Kulit extends BaseController
{
    protected $tkModel;

    public function __construct()
    {
        helper('form');
        $this->tkModel = new TK_model();
    }

    public function index()
    {
        $data = [
            'List_TK' => $this->tkModel->tampildata(),
        ];

        return view('admin/admin_sidebar')
            . view('admin/tone_kulit/index_TK', $data)
            . view('admin/admin_footer');
    }

    public function tambah_data()
    {
        return view('admin/admin_sidebar')
            . view('admin/tone_kulit/tambah_dataTK')
            . view('admin/admin_footer');
    }

    public function proses_tambah_data()
    {
        // Validasi input
        $validation = \Config\Services::validation();
        $validation->setRules([
            'tone_kulit' => 'required|min_length[3]',  // Pastikan data tidak kosong dan panjang minimal 3 karakter
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            // Jika validasi gagal, kembalikan ke form tambah data dengan pesan error
            return redirect()->to('/admin/tone_kulit/tambah')
                ->withInput()
                ->with('errors', $validation->getErrors());
        }

        $tone_kulit = $this->request->getPost('tone_kulit');

        // Siapkan data untuk dimasukkan ke database
        $data = [
            'tone_kulit' => $tone_kulit
        ];

        // Simpan data ke database
        $this->tkModel->tambah_data($data);
        return redirect()->to('/admin/tone_kulit');
    }

    public function hapusdata($id_TK = null)
    {
        if ($id_TK) {
            $this->tkModel->hapusdata($id_TK);
        }
        return redirect()->to('/admin/tone_kulit');
    }

    public function editdata($id_TK = null)
    {
        if (!$id_TK) {
            return redirect()->to('/admin/tone_kulit');
        }

        $data = [
            'dataTK' => $this->tkModel->get_by_id($id_TK)
        ];

        return view('admin/admin_sidebar')
            . view('admin/tone_kulit/editTK', $data)
            . view('admin/admin_footer');
    }

    public function proses_editdata($id_TK = null)
    {
        if (!$id_TK) {
            return redirect()->to('/admin/tone_kulit');
        }

        // Ambil data dari form
        $tone_kulit = $this->request->getPost('tone_kulit');

        // Validasi input, pastikan tidak kosong
        if (empty($tone_kulit)) {
            return redirect()->to('/admin/tone_kulit/editdata/' . $id_TK)
                ->with('error', 'Tone Kulit tidak boleh kosong')
                ->withInput();
        }

        // Siapkan data untuk update
        $data = [
            'tone_kulit' => $tone_kulit
        ];

        // Update data di database
        $this->tkModel->editdata($id_TK, $data);
        return redirect()->to('/admin/tone_kulit');
    }
}
