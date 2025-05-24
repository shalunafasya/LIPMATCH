<?php

namespace App\Controllers;
use App\Models\LoginModel;

class Login extends BaseController
{
    public function index()
    {
        echo view('admin/admin_header');
        echo view('admin/login');
        echo view('admin/admin_footer');
    }

    public function proses()
    {
        $post = $this->request->getPost();

        if (isset($post['login'])) {
            $loginModel = new LoginModel();
            $result = $loginModel->auth($post);

            if ($result->getNumRows() > 0) {
                return redirect()->to('/admin/produk');
            } else {
                return redirect()->to('/login');
            }
        } else {
            return redirect()->to('/login');
        }
    }
    public function home()
    {
        return redirect()->to('/user/awal');
    }
}
