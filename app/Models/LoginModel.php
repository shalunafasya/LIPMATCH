<?php

namespace App\Models;

use CodeIgniter\Model;

class LoginModel extends Model
{
    protected $table = 'user';

    public function auth($post)
    {
        return $this->where('username', $post['username'])
                    ->where('password', $post['password']) 
                    ->get();
    }
}
