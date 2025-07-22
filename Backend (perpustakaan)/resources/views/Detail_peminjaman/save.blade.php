@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <h2 class="text-2xl font-bold mb-4">Tambah Detail Peminjaman</h2>
    <form action="{{ route('detailpeminjaman.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="peminjaman_id" class="block text-gray-700">Peminjaman</label>
            <select name="peminjaman_id" id="peminjaman_id" class="form-select w-full">
                <option value="">-- Pilih Peminjaman --</option>
                @foreach($peminjamans as $peminjaman)
                    <option value="{{ $peminjaman->id }}">{{ $peminjaman->id }} - {{ $peminjaman->anggota->nama ?? 'Anggota' }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label for="buku_id" class="block text-gray-700">Buku</label>
            <select name="buku_id" id="buku_id" class="form-select w-full">
                <option value="">-- Pilih Buku --</option>
                @foreach($bukus as $buku)
                    <option value="{{ $buku->id }}">{{ $buku->judul }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label for="jumlah" class="block text-gray-700">Jumlah</label>
            <input type="number" name="jumlah" id="jumlah" class="form-input w-full" min="1" value="{{ old('jumlah') }}">
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan</button>
        <a href="{{ route('detailpeminjaman.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded ml-2">Kembali</a>
    </form>
</div>
@endsection
