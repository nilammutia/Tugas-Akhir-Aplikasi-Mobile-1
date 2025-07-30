<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Buku;

class BukuController extends Controller
{
    // Get all books
    public function index()
    {
        return response()->json(Buku::all());
    }

    // Get single book
    public function show($id)
    {
        $buku = Buku::find($id);
        if (!$buku) {
            return response()->json(['message' => 'Buku not found'], 404);
        }
        return response()->json($buku);
    }

    // Create new book
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'pengarang' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'tahun_terbit' => 'required|integer',
            'stok' => 'required|integer',
        ]);
        $buku = Buku::create($validated);
        return response()->json($buku, 201);
    }

    // Update book
    public function update(Request $request, $id)
    {
        $buku = Buku::find($id);
        if (!$buku) {
            return response()->json(['message' => 'Buku not found'], 404);
        }
        $validated = $request->validate([
            'judul' => 'sometimes|required|string|max:255',
            'pengarang' => 'sometimes|required|string|max:255',
            'penerbit' => 'sometimes|required|string|max:255',
            'tahun_terbit' => 'sometimes|required|integer',
            'stok' => 'sometimes|required|integer',
        ]);
        $buku->update($validated);
        return response()->json($buku);
    }

    // Delete book
    public function destroy($id)
    {
        $buku = Buku::find($id);
        if (!$buku) {
            return response()->json(['message' => 'Buku not found'], 404);
        }
        $buku->delete();
        return response()->json(['message' => 'Buku deleted']);
    }
}
