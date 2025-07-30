<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Anggota;
use App\Models\Peminjaman;
use App\Models\DetailPeminjaman;

class PeminjamanController extends Controller
{
    // Get all peminjaman
    public function index()
    {
        return response()->json(Peminjaman::with(['detail', 'detail.buku', 'anggota'])->get());
    }

    // Get single peminjaman
    public function show($id)
    {
        $peminjaman = Peminjaman::with(['detail', 'detail.buku', 'anggota'])->find($id);
        if (!$peminjaman) {
            return response()->json(['message' => 'Peminjaman not found'], 404);
        }
        return response()->json($peminjaman);
    }

    // Create new peminjaman
    public function store(Request $req)
    {
        $validated = $req->validate([
            'anggota_id' => 'required|exists:anggotas,id',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date',
            'items' => 'required|array',
            'items.*.buku_id' => 'required|exists:bukus,id',
            'items.*.jumlah' => 'required|integer|min:1',
        ]);
        $peminjaman = Peminjaman::create([
            'anggota_id' => $validated['anggota_id'],
            'tanggal_pinjam' => $validated['tanggal_pinjam'],
            'tanggal_kembali' => $validated['tanggal_kembali'],
        ]);
        foreach ($validated['items'] as $item) {
            DetailPeminjaman::create([
                'peminjaman_id' => $peminjaman->id,
                'buku_id' => $item['buku_id'],
                'jumlah' => $item['jumlah'],
            ]);
        }
        return response()->json($peminjaman->load(['detail', 'detail.buku', 'anggota']), 201);
    }

    // Update peminjaman
    public function update(Request $req, $id)
    {
        $peminjaman = Peminjaman::find($id);
        if (!$peminjaman) {
            return response()->json(['message' => 'Peminjaman not found'], 404);
        }
        $validated = $req->validate([
            'tanggal_pinjam' => 'sometimes|required|date',
            'tanggal_kembali' => 'sometimes|required|date',
            'status' => 'sometimes|required|string',
        ]);
        $peminjaman->update($validated);
        return response()->json($peminjaman);
    }

    // Delete peminjaman
    public function destroy($id)
    {
        $peminjaman = Peminjaman::find($id);
        if (!$peminjaman) {
            return response()->json(['message' => 'Peminjaman not found'], 404);
        }
        $peminjaman->delete();
        return response()->json(['message' => 'Peminjaman deleted']);
    }

    // Get buku
    public function getBuku()
    {
        return response()->json(Buku::all());
    }

    // Riwayat peminjaman user
    public function riwayat(Request $req)
    {
        $anggota = Anggota::where('user_id', $req->user()->id)->first();
        return response()->json(
            Peminjaman::with(['detail', 'detail.buku'])
                ->where('anggota_id', $anggota->id)
                ->get()
        );
    }

    // Pinjam buku
    public function pinjam(Request $req)
    {
        $anggota = Anggota::where('user_id', $req->user()->id)->first();
        $peminjaman = Peminjaman::create([
            'anggota_id' => $anggota->id,
            'tanggal_pinjam' => $req->tanggal_pinjam,
            'tanggal_kembali' => $req->tanggal_kembali,
        ]);
        foreach ($req->items as $item) {
            Detail_Peminjaman::create([
                'peminjaman_id' => $peminjaman->id,
                'buku_id' => $item['buku_id'],
                'jumlah' => $item['jumlah'],
            ]);
        }
        return response()->json(['message' => 'Peminjaman disimpan'], 201);
    }
}


