@extends('layouts.app')

@section('content')
<div class="card shadow border-0 rounded-3">
    <div class="card-header bg-primary text-white text-center py-3">
        <h5 class="mb-0 fw-bold">Registrasi Pengguna</h5>
    </div>
    <div class="card-body p-4">
        <form action="{{ route('register') }}" method="POST">
            @csrf
            
            <div class="mb-3">
                <label class="form-label fw-semibold">Nama Lengkap</label>
                <input type="text" name="name" class="form-control" placeholder="Nama lengkap..." value="{{ old('name') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Email</label>
                <input type="email" name="email" class="form-control" placeholder="Email..." value="{{ old('email') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Password..." required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Alamat</label>
                <textarea name="alamat" class="form-control" rows="2" placeholder="Alamat lengkap..." required>{{ old('alamat') }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Nomor Telepon</label>
                <input type="text" name="nomor_telepon" class="form-control" placeholder="Nomor telepon..." value="{{ old('nomor_telepon') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Nomor SIM</label>
                <input type="text" name="nomor_sim" class="form-control" placeholder="Nomor SIM..." value="{{ old('nomor_sim') }}" required>
            </div>

            <button type="submit" class="btn btn-primary w-100 py-2 fw-bold mb-3">Daftar Akun</button>
        </form>
        
        <div class="text-center">
            <a href="{{ route('login') }}" class="text-decoration-none">Sudah punya akun? Login di sini.</a>
        </div>
    </div>
</div>
@endsection