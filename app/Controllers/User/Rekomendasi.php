<?php

namespace App\Controllers\User; 

use App\Controllers\BaseController;
use App\Models\User\Rekomendasi_model;

class Rekomendasi extends BaseController
{
    protected $rekomendasiModel;

    public function __construct()
    {
        $this->rekomendasiModel = new Rekomendasi_model();
    }

    public function index()
    {
        echo view('user/sidebar_user');
        echo view('user/rekomendasi');
    }

    public function load_produk()
    {
        $jenis_bibir = $this->request->getGet('jenis_bibir');

        if ($jenis_bibir == 'semua') {
            $data = $this->rekomendasiModel->tampil_produk();
        } else {
            $data = $this->rekomendasiModel->tampil_produk_byJB($jenis_bibir);
        }

        return $this->response->setJSON($data);
    }
}
