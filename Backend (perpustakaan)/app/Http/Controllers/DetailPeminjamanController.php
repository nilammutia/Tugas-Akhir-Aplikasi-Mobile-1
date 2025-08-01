<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DetailPeminjaman;
use App\Models\Peminjaman;
use App\Models\Buku;

class DetailPeminjamanController extends Controller
{
    // Tampilkan semua detail peminjaman
    public function index()
    {
        $details = DetailPeminjaman::with(['peminjaman', 'buku'])->get();
        return view('detailpeminjaman.index', compact('details'));
    }

    // Tampilkan form tambah detail peminjaman
    public function create()
    {
        $peminjamans = Peminjaman::all();
        $bukus = Buku::where('stok', '>', 0)->get(); // hanya buku yang tersedia
        return view('detailpeminjaman.create', compact('peminjamans', 'bukus'));
    }

    // Simpan detail peminjaman
    public function store(Request $request)
    {
        $request->validate([
            'peminjaman_id' => 'required|exists:peminjaman,id',
            'buku_id' => 'required|exists:bukus,id',
            'jumlah' => 'required|integer|min:1',
        ]);

        $buku = Buku::findOrFail($request->buku_id);

        if ($buku->stok < $request->jumlah) {
            return back()->with('error', 'Stok buku tidak mencukupi!');
        }

        // Simpan peminjaman detail
        DetailPeminjaman::create([
            'peminjaman_id' => $request->peminjaman_id,
            'buku_id' => $request->buku_id,
            'jumlah' => $request->jumlah,
            'status' => 'Belum Kembali',
        ]);

        // Kurangi stok buku
        $buku->stok -= $request->jumlah;
        $buku->save();

        return redirect()->route('detailpeminjaman.index')->with('success', 'Detail peminjaman ditambahkan.');
    }

    // Logika pengembalian buku
    public function kembalikan($id)
    {
        $detail = DetailPeminjaman::findOrFail($id);

        if ($detail->status === 'Sudah Dikembalikan') {
            return back()->with('info', 'Buku sudah dikembalikan sebelumnya.');
        }

        $detail->status = 'Sudah Dikembalikan';
        $detail->save();

        // Tambahkan kembali stok
        $buku = Buku::find($detail->buku_id);
        $buku->stok += $detail->jumlah;
        $buku->save();

        return redirect()->back()->with('success', 'Buku berhasil dikembalikan dan stok diperbarui.');
    }

    // Update detail peminjaman
    public function update(Request $request, $id)
    {
        $request->validate([
            'peminjaman_id' => 'required|exists:peminjaman,id',
            'buku_id' => 'required|exists:bukus,id',
            'jumlah' => 'required|integer|min:1',
            'status' => 'required',
        ]);
        $detail = DetailPeminjaman::findOrFail($id);
        $statusLama = $detail->status;

        // Jika status berubah ke 'Sudah Dikembalikan' dan sebelumnya belum
        if ($request->status === 'Sudah Dikembalikan' && $statusLama !== 'Sudah Dikembalikan') {
            $buku = Buku::find($request->buku_id);
            if ($buku) {
                $buku->stok += $request->jumlah;
                $buku->save();
            }
        }

        $detail->update($request->all());

        // Cek jika semua detail pada peminjaman ini sudah dikembalikan, update status peminjaman
        $peminjaman = Peminjaman::find($request->peminjaman_id);
        if ($peminjaman) {
            $semuaKembali = $peminjaman->detail()->where('status', 'Belum Kembali')->count() === 0;
            if ($semuaKembali) {
                $peminjaman->status = 'Kembali';
                $peminjaman->save();
            } else {
                $peminjaman->status = 'Dipinjam';
                $peminjaman->save();
            }
        }

        return redirect()->route('detailpeminjaman.index')->with('success', 'Detail peminjaman berhasil diupdate');
    }
}
