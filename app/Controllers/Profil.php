<?php

namespace App\Controllers;

class Profil extends BaseController
{
    public function index()
    {
        $data = [
            'username'    => session()->get('username'),
            'role'        => session()->get('role'),
            'email'       => session()->get('email'),
            'waktu_login' => session()->get('waktu_login'),
            'status'      => session()->get('log') ? 'Aktif' : 'Tidak Aktif'
        ];

        return view('v_profil', $data);
    }
}