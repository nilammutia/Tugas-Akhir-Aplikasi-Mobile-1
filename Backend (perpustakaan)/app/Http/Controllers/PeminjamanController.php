<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Anggota;
use App\Models\Buku;
use Illuminate\Support\Facades\DB;

class PeminjamanController extends Controller
{
    // Tampilkan daftar semua peminjaman
    public function index()
    {
        $peminjaman = Peminjaman::with(['anggota', 'buku'])->get();
        return view('peminjaman.index', compact('peminjaman'));
    }

    // Tampilkan form untuk menambahkan peminjaman
    public function create()
    {
        $anggotas = Anggota::all();
        $bukus = Buku::where('stok', '>', 0)->get(); // hanya buku yang tersedia
        return view('peminjaman.create', compact('anggotas', 'bukus'));
    }

    // Simpan data peminjaman baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'anggota_id' => 'required|exists:anggotas,id',
            'buku_id' => 'required|exists:bukus,id',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'nullable|date',
            'status' => 'required|in:dipinjam,dikembalikan',
        ]);

        $buku = Buku::findOrFail($validated['buku_id']);

        if ($buku->stok <= 0) {
            return back()->withErrors(['stok' => 'Stok buku habis, tidak bisa dipinjam.'])->withInput();
        }

        DB::transaction(function () use ($validated, $buku) {
            $buku->decrement('stok');
            Peminjaman::create($validated);
        });

        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil ditambahkan.');
    }

    // Tampilkan form untuk mengedit peminjaman
    public function edit($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $anggotas = Anggota::all();
        $bukus = Buku::all();
        return view('peminjaman.edit', compact('peminjaman', 'anggotas', 'bukus'));
    }

    // Update data peminjaman
    public function update(Request $request, $id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        $validated = $request->validate([
            'anggota_id' => 'required|exists:anggotas,id',
            'buku_id' => 'required|exists:bukus,id',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'nullable|date',
            'status' => 'required|in:dipinjam,dikembalikan',
        ]);

        // Jika status diubah dari "dipinjam" ke "dikembalikan", tambahkan stok buku
        if ($peminjaman->status !== 'dikembalikan' && $validated['status'] === 'dikembalikan') {
            $buku = Buku::findOrFail($validated['buku_id']);
            $buku->increment('stok');
        }

        $peminjaman->update($validated);

        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil diperbarui.');
    }

    // Hapus peminjaman
    public function destroy($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        // Tambahkan kembali stok jika status masih "dipinjam"
        if ($peminjaman->status === 'dipinjam') {
            $buku = Buku::findOrFail($peminjaman->buku_id);
            $buku->increment('stok');
        }

        $peminjaman->delete();

        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil dihapus.');
    }
}
