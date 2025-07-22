<?php

namespace App\Http\Controllers\API;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Anggota;
use App\Models\Peminjaman;
use App\Models\Detail_Peminjaman;

class PeminjamanController extends Controller
{
    public function getBuku()
    {
        return Buku::all();
    }

    public function riwayat(Request $req)
    {
        $anggota = Anggota::where('user_id', $req->user()->id)->first();
        return Peminjaman::with(['detail', 'detail.buku'])
            ->where('anggota_id', $anggota->id)
            ->get();
    }

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


