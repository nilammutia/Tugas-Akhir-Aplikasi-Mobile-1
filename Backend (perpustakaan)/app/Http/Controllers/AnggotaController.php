<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\Anggota;

class AnggotaController extends Controller
{
    // Tampilkan daftar anggota
    public function index()
    {
        $anggotas = Anggota::all();
        return view('anggota.index', compact('anggotas'));
    }

    // Tampilkan form tambah anggota
    public function create()
    {
        return view('anggota.create');
    }

    // Simpan data anggota baru
    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required',
            'alamat' => 'required',
            'telepon' => 'required',
            'email' => 'required|email|unique:anggotas,email',
        ]);
        $data['tanggal daftar'] = now()->format('Y-m-d');
        Anggota::create($data);
        return redirect()->route('anggota.index')->with('success', 'Anggota berhasil ditambahkan');
    }

    // Tampilkan form edit anggota
    public function edit($id)
    {
        $anggota = Anggota::findOrFail($id);
        return view('anggota.edit', compact('anggota'));
    }

    // Update data anggota
    public function update(Request $request, $id)
    {
        $anggota = Anggota::findOrFail($id);
        $anggota->update($request->validate([
            'nama' => 'required',
            'alamat' => 'required',
            'telepon' => 'required',
            'email' => 'required|email|unique:anggotas,email,' . $id,
        ]));
        return redirect()->route('anggota.index')->with('success', 'Anggota berhasil diupdate');
    }
}
