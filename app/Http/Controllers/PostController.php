<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index() {
        return 'Ini Halaman Daftar Post (INDEX)';
    }

    public function create() {
        return 'Form Tambah Post (CREATE)';
    }

    public function store(Request $request) {
        return 'Proses simpan post baru (STORE)';
    }

    public function show(string $id) {
        return "Tampilkan detail post dengan ID: $id (SHOW)";
    }
}
