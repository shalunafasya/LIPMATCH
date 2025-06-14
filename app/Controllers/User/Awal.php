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
        $nama = $this->request->getPost('nama');
        $kategori_uang = $this->request->getPost('kategori_uang');
        $tone_kulit = $this->request->getPost('cek_tone');


        if (empty($tone_kulit) || $tone_kulit == '0') {
            return redirect()->back()->with('error', 'Tone kulit belum dipilih!');
        }

        session()->set('SESS_KBS_LIPSTIK_NAMA', $nama);

        if (!session()->has('SESS_KBS_LIPSTIK_ID_USER')) {
            session()->set('SESS_KBS_LIPSTIK_ID_USER', random_int(1000, 999999));
        }

        session()->set('SESS_KBS_LIPSTIK_KATEGORI_FINANSIAL', $kategori_uang);
        session()->set('SESS_KBS_LIPSTIK_TONE_KULIT', $tone_kulit);

        return redirect()->to('/user/jenis_bibir');
    }
}
