<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DetailPeminjaman;
use App\Models\Peminjaman;
use App\Models\Buku;

class DetailPeminjamanController extends Controller
{
    // Tampilkan semua detail peminjaman (API JSON)
    public function index()
    {
        $details = DetailPeminjaman::with(['peminjaman', 'buku'])->get();
        return response()->json($details);
    }

    // Endpoint untuk kebutuhan data referensi create (API JSON)
    public function create()
    {
        $peminjamans = Peminjaman::all();
        $bukus = Buku::where('stok', '>', 0)->get();
        return response()->json([
            'peminjamans' => $peminjamans,
            'bukus' => $bukus
        ]);
    }

    // Simpan detail peminjaman (API JSON)
    public function store(Request $request)
    {
        $request->validate([
            'peminjaman_id' => 'required|exists:peminjaman,id',
            'buku_id' => 'required|exists:bukus,id',
            'jumlah' => 'required|integer|min:1',
        ]);

        $buku = Buku::findOrFail($request->buku_id);
        if ($buku->stok < $request->jumlah) {
            return response()->json(['error' => 'Stok buku tidak mencukupi!'], 422);
        }

        $detail = DetailPeminjaman::create([
            'peminjaman_id' => $request->peminjaman_id,
            'buku_id' => $request->buku_id,
            'jumlah' => $request->jumlah,
            'status' => 'Belum Kembali',
        ]);

        $buku->stok -= $request->jumlah;
        $buku->save();

        return response()->json([
            'message' => 'Detail peminjaman ditambahkan.',
            'data' => $detail
        ], 201);
    }

    // Logika pengembalian buku (API JSON)
    public function kembalikan($id)
    {
        $detail = DetailPeminjaman::findOrFail($id);
        if ($detail->status === 'Sudah Dikembalikan') {
            return response()->json(['info' => 'Buku sudah dikembalikan sebelumnya.']);
        }
        $detail->status = 'Sudah Dikembalikan';
        $detail->save();
        $buku = Buku::find($detail->buku_id);
        $buku->stok += $detail->jumlah;
        $buku->save();
        return response()->json(['message' => 'Buku berhasil dikembalikan dan stok diperbarui.']);
    }

    // Update detail peminjaman (API JSON)
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
        $validated = $request->all();
        if ($validated['status'] === 'Sudah Dikembalikan' && $statusLama !== 'Sudah Dikembalikan') {
            $buku = Buku::find($validated['buku_id']);
            if ($buku) {
                $buku->stok += $validated['jumlah'];
                $buku->save();
            }
        }
        $detail->update($validated);
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
        return response()->json([
            'message' => 'Detail peminjaman berhasil diupdate',
            'data' => $detail
        ]);
    }
}
