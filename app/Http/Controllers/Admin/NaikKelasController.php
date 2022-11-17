<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class NaikKelasController extends Controller
{
   
    public function index()
    {
        $data['something'] = 'Something';

        return view('costum.naik-kelas', $data);
    }
}