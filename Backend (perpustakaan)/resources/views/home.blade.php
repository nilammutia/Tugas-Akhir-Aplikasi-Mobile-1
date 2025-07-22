@extends('layouts.app')

@section('content')
    @guest
        <div class="max-w-md mx-auto mt-10 bg-white p-8 rounded shadow">
            <h2 class="text-2xl font-bold mb-6 text-center">Login</h2>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-4">
                    <label for="email" class="block text-gray-700">Email</label>
                    <input type="email" name="email" id="email" class="form-input w-full" required autofocus>
                </div>
                <div class="mb-6">
                    <label for="password" class="block text-gray-700">Password</label>
                    <input type="password" name="password" id="password" class="form-input w-full" required>
                </div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded w-full">Login</button>
            </form>
        </div>
    @else
        <h1>Selamat Datang di Perpustakaan, {{ Auth::user()->name }}!</h1>
    @endguest
@endsection