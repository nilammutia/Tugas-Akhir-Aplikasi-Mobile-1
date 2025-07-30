@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Daftar Peminjaman</h1>

    {{-- Notifikasi Success --}}
    @if (session('success'))
        <div style="background-color: #d4edda; color: #155724; padding: 10px; border: 1px solid #c3e6cb; margin-bottom: 15px;">
            {{ session('success') }}
        </div>
    @endif

    {{-- Notifikasi Error --}}
    @if ($errors->any())
        <div style="background-color: #f8d7da; color: #721c24; padding: 10px; border: 1px solid #f5c6cb; margin-bottom: 15px;">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <a href="{{ route('peminjaman.create') }}" class="btn btn-primary mb-3">+ Tambah Peminjaman</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Anggota</th>
                <th>Buku</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Kembali</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($peminjaman as $data)
                <tr>
                    <td>{{ $data->id }}</td>
                    <td>{{ $data->anggota->nama ?? '-' }}</td>
                    <td>{{ $data->buku->judul ?? '-' }}</td>
                    <td>{{ $data->tanggal_pinjam }}</td>
                    <td>{{ $data->tanggal_kembali ?? '-' }}</td>
                    <td>{{ ucfirst($data->status) }}</td>
                    <td>
                        <form action="{{ route('peminjaman.destroy', $data->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin hapus?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" type="submit">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Belum ada data peminjaman</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
