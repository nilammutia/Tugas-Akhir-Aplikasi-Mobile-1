@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detail Anggota</h1>
    <div class="card">
        <div class="card-body">
            <p><strong>Nama:</strong> {{ $anggota->nama }}</p>
            <p><strong>Alamat:</strong> {{ $anggota->alamat }}</p>
            <p><strong>Telepon:</strong> {{ $anggota->telepon }}</p>
            <p><strong>Email:</strong> {{ $anggota->email }}</p>
        </div>
    </div>
    <a href="{{ route('anggota.index') }}" class="btn btn-secondary mt-3">Kembali</a>
</div>
@endsection
