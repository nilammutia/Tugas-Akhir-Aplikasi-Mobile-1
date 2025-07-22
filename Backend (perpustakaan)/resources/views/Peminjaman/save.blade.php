@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detail Peminjaman</h1>
    <div class="card">
        <div class="card-body">
            <p><strong>Nama Anggota:</strong> {{ $peminjaman->anggota->nama ?? '-' }}</p>
            <p><strong>Judul Buku:</strong> {{ $peminjaman->buku->judul ?? '-' }}</p>
            <p><strong>Tanggal Pinjam:</strong> {{ $peminjaman->tanggal_pinjam }}</p>
            <p><strong>Tanggal Kembali:</strong> {{ $peminjaman->tanggal_kembali ?? '-' }}</p>
            <p><strong>Status:</strong> {{ $peminjaman->status }}</p>
        </div>
    </div>
    <a href="{{ route('peminjaman.index') }}" class="btn btn-secondary mt-3">Kembali</a>
</div>
@endsection
