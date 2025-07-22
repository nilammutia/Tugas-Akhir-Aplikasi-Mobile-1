<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Detail_Peminjaman;
use App\Models\Peminjaman;
use App\Models\Buku;

class DetailPeminjamanController extends Controller
{
    // Display a listing of the resource
    public function index()
    {
        $details = Detail_Peminjaman::with(['peminjaman', 'buku'])->get();
        return view('DetailPeminjaman.index', compact('details'));
    }

    // Show the form for creating a new resource
    public function create()
    {
        $peminjamans = Peminjaman::all();
        $bukus = Buku::all();
        return view('DetailPeminjaman.create', compact('peminjamans', 'bukus'));
    }

    // Store a newly created resource in storage
    public function store(Request $request)
    {
        $request->validate([
            'peminjaman_id' => 'required|exists:peminjamen,id',
            'buku_id' => 'required|exists:bukus,id',
            'jumlah' => 'required|integer|min:1',
        ]);
        Detail_Peminjaman::create($request->all());
        return redirect()->route('detailpeminjaman.index')->with('success', 'Detail peminjaman berhasil ditambahkan');
    }

    // Show the form for editing the specified resource
    public function edit($id)
    {
        $detail = Detail_Peminjaman::findOrFail($id);
        $peminjamans = Peminjaman::all();
        $bukus = Buku::all();
        return view('DetailPeminjaman.edit', compact('detail', 'peminjamans', 'bukus'));
    }

    // Update the specified resource in storage
    public function update(Request $request, $id)
    {
        $request->validate([
            'peminjaman_id' => 'required|exists:peminjamen,id',
            'buku_id' => 'required|exists:bukus,id',
            'jumlah' => 'required|integer|min:1',
        ]);
        $detail = Detail_Peminjaman::findOrFail($id);
        $detail->update($request->all());
        return redirect()->route('detailpeminjaman.index')->with('success', 'Detail peminjaman berhasil diupdate');
    }

    // Remove the specified resource from storage
    public function destroy($id)
    {
        $detail = Detail_Peminjaman::findOrFail($id);
        $detail->delete();
        return redirect()->route('detailpeminjaman.index')->with('success', 'Detail peminjaman berhasil dihapus');
    }
}
