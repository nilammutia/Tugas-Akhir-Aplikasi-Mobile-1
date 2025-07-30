@extends('layouts.app') {{-- Pastikan layout utama kamu bernama layouts.app --}}

@section('title', 'Daftar Buku')

@section('content')
<div class="container mt-4">
    <h2>Daftar Buku</h2>

    @if (session('success'))
        <div class="alert alert-success mt-2">
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-3">
        <a href="{{ route('buku.create') }}" class="btn btn-primary"> Tambah Buku</a>
    </div>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Judul</th>
                <th>Penulis</th>
                <th>Penerbit</th>
                <th>Tahun Terbit</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($bukus as $index => $buku)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $buku->judul }}</td>
                    <td>{{ $buku->penulis ?? '-' }}</td>
                    <td>{{ $buku->penerbit ?? '-' }}</td>
                    <td>{{ $buku->tahun_terbit ?? '-' }}</td>
                    <td>{{ $buku->stok }}</td>
                    <td>
                        <a href="{{ route('buku.edit', $buku->id) }}" class="btn btn-warning btn-sm">Edit</a>

                        <form action="{{ route('buku.destroy', $buku->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Yakin ingin menghapus buku ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Tidak ada data buku</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
