@extends('layouts.app')

@section('content')
<div class="card shadow border-0 rounded-3">
    <div class="card-header bg-dark text-white text-center py-3">
        <h5 class="mb-0 fw-bold">Login Pengguna</h5>
    </div>
    <div class="card-body p-4">
        <form action="{{ route('login') }}" method="POST">
            @csrf
            
            <div class="mb-3">
                <label class="form-label fw-semibold">Email</label>
                <input type="email" name="email" class="form-control" placeholder="Masukkan email..." required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Masukkan password..." required>
            </div>

            <button type="submit" class="btn btn-dark w-100 py-2 fw-bold mb-3">Login</button>
        </form>

        <div class="text-center">
            <a href="{{ route('register') }}" class="text-decoration-none">Belum punya akun? Daftar di sini.</a>
        </div>
    </div>
</div>
@endsection