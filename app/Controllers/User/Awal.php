<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\User\Awal_Model;

class Awal extends BaseController
{
    protected $Awal_Model;

    public function __construct()
    {
        $this->Awal_Model = new Awal_Model(); 
    }

    public function index()
    {
        $tone_kulit = $this->Awal_Model->getToneKulit(); 
        return view('user/halamanawal', ['tone_kulit' => $tone_kulit]);
    }


    public function simpan_nama()
    {
        // Mengambil input dari form POST
        $nama = $this->request->getPost('nama');
        $umur = $this->request->getPost('umur');
        $kategori_uang = $this->request->getPost('kategori_uang');
        $tone_kulit = $this->request->getPost('cek_tone');

        if (empty($tone_kulit) || $tone_kulit == '0') {
        return redirect()->back()->with('error', 'Tone kulit belum dipilih!');
        }

        // Menyimpan data session
        session()->set('sess_lipstik_nama', $nama);
        session()->set('sess_lipstik_umur', $umur);
        session()->set('sess_lipstik_uang', $kategori_uang);
        session()->set('SESS_KBS_LIPSTIK_KATEGORI_FINANSIAL', $kategori_uang);
        session()->set('sess_tone_kulit', $tone_kulit);

        // Redirect ke 'User/Jenis_Kulit'
        return redirect()->to('/user/jenis_bibir');
    }
}
