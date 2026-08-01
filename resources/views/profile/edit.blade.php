@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-1">
            <i class="bi bi-person-circle me-2 text-primary"></i>Profil Pengguna
        </h3>
        <p class="text-muted small mb-0">Lihat dan perbarui informasi pribadi akun Anda</p>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-4">
        <div class="card shadow-sm border-0 rounded-3 text-center p-4">
            <div class="mb-3">
                <i class="bi bi-person-bounding-box text-primary" style="font-size: 4rem;"></i>
            </div>
            <h5 class="fw-bold mb-1">{{ $user->name }}</h5>
            <p class="text-muted small mb-3">{{ $user->email }}</p>
            
            <div class="border-top pt-3 text-start">
                <div class="mb-2">
                    <small class="text-muted d-block">Nomor SIM:</small>
                    <span class="badge bg-dark fs-6">{{ $user->nomor_sim }}</span>
                </div>
                <div class="mb-2">
                    <small class="text-muted d-block">Nomor Telepon:</small>
                    <span class="fw-semibold text-dark"><i class="bi bi-telephone me-1"></i>{{ $user->nomor_telepon }}</span>
                </div>
                <div>
                    <small class="text-muted d-block">Alamat:</small>
                    <span class="text-dark"><i class="bi bi-geo-alt me-1"></i>{{ $user->alamat }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-header bg-dark text-white py-3">
                <h5 class="card-title mb-0 fw-bold fs-6">
                    <i class="bi bi-pencil-square me-2"></i>Perbarui Informasi Pribadi
                </h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Nomor Telepon</label>
                            <input type="text" name="nomor_telepon" class="form-control" value="{{ old('nomor_telepon', $user->nomor_telepon) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Nomor SIM</label>
                            <input type="text" name="nomor_sim" class="form-control" value="{{ old('nomor_sim', $user->nomor_sim) }}" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Alamat Lengkap</label>
                            <textarea name="alamat" class="form-control" rows="3" required>{{ old('alamat', $user->alamat) }}</textarea>
                        </div>
                        <hr class="my-4">
                        <h6 class="fw-bold text-muted mb-0"><i class="bi bi-shield-lock me-1"></i>Ganti Password (Opsional)</h6>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Password Baru</label>
                            <input type="password" name="password" class="form-control" placeholder="Biarkan kosong jika tidak diganti">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password baru">
                        </div>
                    </div>
                    <div class="mt-4 text-end">
                        <button type="submit" class="btn btn-primary px-4 py-2 fw-bold">
                            <i class="bi bi-save me-1"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection