@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Daftar Detail Peminjaman</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @elseif(session('info'))
        <div class="alert alert-info">{{ session('info') }}</div>
    @endif

    <a href="{{ route('detailpeminjaman.create') }}" class="btn btn-primary mb-3">Tambah Detail Peminjaman</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Anggota</th>
                <th>Judul Buku</th>
                <th>Jumlah</th>
                <th>Status</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Kembali</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($details as $key => $item)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $item->peminjaman->anggota->nama ?? '-' }}</td>
                    <td>{{ $item->buku->judul ?? '-' }}</td>
                    <td>{{ $item->jumlah }}</td>
                    <td>{{ $item->status }}</td>
                    <td>{{ $item->peminjaman->tanggal_pinjam }}</td>
                    <td>{{ $item->peminjaman->tanggal_kembali ?? '-' }}</td>
                    <td>
                        @if($item->status === 'Belum Kembali')
                            <a href="{{ route('detailpeminjaman.kembalikan', $item->id) }}"
                               onclick="return confirm('Yakin buku sudah dikembalikan?')"
                               class="btn btn-success btn-sm">
                               Kembalikan
                            </a>
                        @else
                            <span class="text-muted">✓</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">Belum ada data detail peminjaman.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
