<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Admin\Produk_model;
use App\Models\Admin\JL_model;
use App\Models\Admin\JB_model;
use App\Models\Admin\TK_model;

class Produk extends BaseController
{
    protected $produkModel;
    protected $jlModel;
    protected $jbModel;
    protected $tkModel;

    public function __construct()
    {
        helper('form');
        $this->produkModel = new Produk_model();
        $this->jlModel = new JL_model();
        $this->jbModel = new JB_model();
        $this->tkModel = new TK_model();
    }

    public function index()
    {
        $data = [
            'List_Produk' => $this->produkModel->tampildata(),
            'List_TK' => $this->tkModel->findAll(),
            'List_JB' => $this->jbModel->findAll()
        ];

        return view('admin/admin_sidebar')
            . view('admin/produk/index', $data)
            . view('admin/admin_footer');
    }

    public function tambah_data()
    {
        $data = [
            'List_JB' => $this->jbModel->findAll(),  
            'List_JS' => $this->jlModel->findAll(),
            'List_TK' => $this->tkModel->findAll()   
        ];

        return view('admin/admin_sidebar')
            . view('admin/produk/tambah_dataproduk', $data)
            . view('admin/admin_footer');
    }

    public function proses_tambah_data()
    {
        if (!$this->validate([
            'jenis_lipstik' => 'required',
            'merk_produk'   => 'required',
            'kondisi_bibir' => 'required',
            'nama_produk'   => 'required',
            'tone_kulit'    => 'required',
            'image'         => 'uploaded[image]|max_size[image,2048]|is_image[image]|ext_in[image,jpg,jpeg,png,gif]' // Validasi file gambar
        ])) {
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan data, periksa form input.');
        }

        $data = [
            'jenis_lipstik' => $this->request->getPost('jenis_lipstik'),
            'merk_produk'   => $this->request->getPost('merek_produk'),
            'id_JB' => implode(',', $this->request->getPost('kondisi_bibir')),
            'nama_produk'    => $this->request->getPost('nama_produk'),
            'id_tk' => implode(',', $this->request->getPost('tone_kulit')),

        ];

        $upload = $this->produkModel->upload();
        if ($upload['result'] === "success") {
            $data['gambar'] = $upload['file']; 
        }

        $this->produkModel->insert($data);

        return redirect()->to('/admin/produk');
    }

    public function hapusdata($id = null)
    {
        if ($id) {
            $this->produkModel->delete($id); 
        }
        return redirect()->to('/admin/produk');
    }

    public function editdata($id_produk = null)
    {
        if ($id_produk && $this->produkModel->find($id_produk)) {
            $data = [
                'List_JB'     => $this->jbModel->findAll(),
                'List_JS'     => $this->jlModel->findAll(),
                'List_TK'     => $this->tkModel->findAll(),
                'data_produk' => $this->produkModel->find($id_produk) 
            ];

            return view('admin/admin_sidebar')
                . view('admin/produk/editproduk', $data)
                . view('admin/admin_footer');
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }

    public function proses_editdata($id_produk = null)
    {
        if (!$id_produk) return redirect()->to('/admin/produk');

        if (!$this->validate([
            'jenis_lipstik' => 'required',
            'merek_produk'   => 'required',
            'kondisi_bibir'  => 'required',
            'nama_produk'    => 'required',
            'tone_kulit'    => 'required',
            'image' => 'permit_empty|is_image[image]|max_size[image,2048]|ext_in[image,jpg,jpeg,png,gif]'
        ])) {
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui data, periksa form input.');
        }

        $data = [
            'jenis_lipstik' => $this->request->getPost('jenis_lipstik'),
            'merk_produk'   => $this->request->getPost('merek_produk'),
            'id_JB' => implode(',', $this->request->getPost('kondisi_bibir')),
            'nama_produk'    => $this->request->getPost('nama_produk'),
            'id_tk' => implode(',', $this->request->getPost('tone_kulit')),
            'harga'          => $this->request->getPost('harga_produk'),
        ];

        $file = $this->request->getFile('image');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newFileName = uniqid() . '.' . $file->getExtension();
            $file->move(ROOTPATH . 'public/assets/image/produk', $newFileName);
            $data['gambar'] = $newFileName;
        } else {
            $oldGambar = $this->request->getPost('old_gambar');
            if (!empty($oldGambar)) {
                $data['gambar'] = $oldGambar;
            } else {
                unset($data['gambar']); 
            }
        }        

        $this->produkModel->update($id_produk, $data);

        return redirect()->to('/admin/produk');
    }
    
    public function proses_tambah_data_v1()
{
    // dd($this->request->getPost('kondisi_bibir'));

    $data = [];
    
    $gambar = $this->request->getFile('image');
    
    if ($gambar && $gambar->isValid() && !$gambar->hasMoved()) {
        $newFileName = uniqid() . '.' . $gambar->getExtension();
        $gambar->move(ROOTPATH . 'public/assets/image/produk', $newFileName); 

        $data = [
            'jenis_lipstik' => $this->request->getPost('jenis_lipstik'),
            'merk_produk' => $this->request->getPost('merek_produk'),
            'id_JB' => implode(',', $this->request->getPost('kondisi_bibir')),
            'nama_produk' => $this->request->getPost('nama_produk'),
            'id_tk' => implode(',', $this->request->getPost('tone_kulit')),
            'harga' => $this->request->getPost('harga_produk'),
            'gambar' => $newFileName,  
        ];
        // dd($data);

        $this->produkModel->tambah_data($data);

        return redirect()->to('/admin/Produk');
    } else {
        $message = 'File upload gagal: ' . ($gambar ? $gambar->getErrorString() : 'No file uploaded');
        session()->setFlashdata('message', $message);
        return redirect()->to('/admin/Produk/tambah_data');
    }
}

}
