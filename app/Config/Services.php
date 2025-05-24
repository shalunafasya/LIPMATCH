<?php

// app/Config/Services.php

namespace Config;

use CodeIgniter\Config\BaseService;

class Services extends BaseService
{
    // Layanan upload file
    public static function upload($getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('upload');
        }

        return new \CodeIgniter\Files\File('./public/assets/image/produk'); // Jangan lupa ubah path jika diperlukan
    }
}
