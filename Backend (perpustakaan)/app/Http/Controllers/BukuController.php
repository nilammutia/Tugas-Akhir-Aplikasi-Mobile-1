<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Buku;

class BukuController extends Controller
{
    // Tampilkan daftar buku
    public function index()
    {
        $bukus = Buku::all();
        return view('buku.index', compact('bukus'));
    }

    // Tampilkan form tambah buku
    public function create()
    {
        return view('buku.create');
    }

    // Simpan data buku baru
    public function store(Request $request)
    {
        Buku::create($request->validate([
            'judul' => 'required',
            'penulis' => 'required',
            'penerbit' => 'required',
            'tahun_terbit' => 'required|integer',
        ]));
        return redirect()->route('buku.index')->with('success', 'Buku berhasil ditambahkan');
    }

    // Tampilkan form edit buku
    public function edit($id)
    {
        $buku = Buku::findOrFail($id);
        return view('buku.edit', compact('buku'));
    }

    // Update data buku
    public function update(Request $request, $id)
    {
        $buku = Buku::findOrFail($id);
        $buku->update($request->validate([
            'judul' => 'required',
            'penulis' => 'required',
            'penerbit' => 'required',
            'tahun_terbit' => 'required|integer',
        ]));
        return redirect()->route('buku.index')->with('success', 'Buku berhasil diupdate');
    }
}
