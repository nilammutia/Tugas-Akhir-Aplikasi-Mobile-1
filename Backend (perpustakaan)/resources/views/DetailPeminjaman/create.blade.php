@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Tambah Detail Peminjaman</h2>

    <form action="{{ route('detailpeminjaman.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="peminjaman_id" class="form-label">Nama Anggota</label>
            <select name="peminjaman_id" class="form-control" required>
                <option value="">-- Pilih Anggota --</option>
                @foreach($peminjamans as $p)
                    <option value="{{ $p->id }}">{{ $p->anggota->nama ?? 'Tidak diketahui' }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="buku_id" class="form-label">Pilih Buku</label>
            <select name="buku_id" class="form-control" required>
                <option value="">-- Pilih Buku --</option>
                @foreach($bukus as $buku)
                    <option value="{{ $buku->id }}">{{ $buku->judul }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="jumlah" class="form-label">Jumlah</label>
            <input type="number" name="jumlah" class="form-control" min="1" value="1" required>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" class="form-control" required>
                <option value="Belum Kembali">Belum Kembali</option>
                <option value="Sudah Dikembalikan">Sudah Dikembalikan</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>

<!-- Kode otomatisasi dihapus, input anggota dan buku sekarang manual -->
@endsection
