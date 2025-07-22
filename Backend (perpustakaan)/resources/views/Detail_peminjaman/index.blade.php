@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <h2 class="text-2xl font-bold mb-4">Data Detail Peminjaman</h2>
    <a href="{{ route('detailpeminjaman.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">Tambah Detail Peminjaman</a>
    <table class="min-w-full bg-white border rounded">
        <thead>
            <tr>
                <th class="py-2 px-4 border-b">ID</th>
                <th class="py-2 px-4 border-b">Peminjaman</th>
                <th class="py-2 px-4 border-b">Buku</th>
                <th class="py-2 px-4 border-b">Jumlah</th>
                <th class="py-2 px-4 border-b">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($details as $detail)
            <tr>
                <td class="py-2 px-4 border-b">{{ $detail->id }}</td>
                <td class="py-2 px-4 border-b">{{ $detail->peminjaman->id ?? '-' }} - {{ $detail->peminjaman->anggota->nama ?? '-' }}</td>
                <td class="py-2 px-4 border-b">{{ $detail->buku->judul ?? '-' }}</td>
                <td class="py-2 px-4 border-b">{{ $detail->jumlah }}</td>
                <td class="py-2 px-4 border-b">
                    <a href="{{ route('detailpeminjaman.edit', $detail->id) }}" class="bg-yellow-500 text-white px-2 py-1 rounded">Edit</a>
                    <form action="{{ route('detailpeminjaman.destroy', $detail->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
