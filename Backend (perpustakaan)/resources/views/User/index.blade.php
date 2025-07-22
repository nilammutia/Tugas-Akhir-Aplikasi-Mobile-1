@extends('layouts.app')
@section('content')
<h1>Daftar User</h1>
<a class="btn btn-primary mb-3" href="{{ route('user.create') }}">Tambah User</a>

<table class="table table-striped">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Email</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($user as $u)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $u->name }}</td>
            <td>{{ $u->email }}</td>
            <td>
                <a class="btn btn-warning btn-sm" href="{{ route('user.edit', $u->id) }}">Edit</a>
                <form action="{{ route('user.destroy', $u->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus user ini?')">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
