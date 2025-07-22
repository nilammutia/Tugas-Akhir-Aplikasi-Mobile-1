@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detail Buku</h1>
    <div class="card">
        <div class="card-body">
            <p><strong>Judul:</strong> {{ $buku->judul }}</p>
            <p><strong>Penulis:</strong> {{ $buku->penulis }}</p>
            <p><strong>Penerbit:</strong> {{ $buku->penerbit }}</p>
            <p><strong>Tahun Terbit:</strong> {{ $buku->tahun_terbit }}</p>
        </div>
    </div>
    <a href="{{ route('buku.index') }}" class="btn btn-secondary mt-3">Kembali</a>
</div>
@endsection
