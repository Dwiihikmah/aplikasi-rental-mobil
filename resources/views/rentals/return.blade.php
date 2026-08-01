@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6 col-md-8">
        
        <div class="mb-3 text-center">
            <h4 class="fw-bold text-dark mb-1">Pengembalian Mobil</h4>
            <p class="text-muted small">Masukkan plat mobil untuk menyelesaikan masa sewa</p>
        </div>

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-header bg-dark text-white px-4 py-3 border-0 d-flex align-items-center">
                <div class="bg-warning text-dark p-2 rounded-3 me-3 d-inline-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                    <i class="bi bi-arrow-return-left fs-5"></i>
                </div>
                <div>
                    <h6 class="mb-0 fw-bold">Konfirmasi Pengembalian</h6>
                    <small class="text-white-50">Sistem akan menghitung total biaya secara otomatis</small>
                </div>
            </div>

            <div class="card-body p-4">
                
                <div class="alert alert-warning border-0 rounded-3 d-flex align-items-start mb-4" role="alert">
                    <i class="bi bi-exclamation-triangle-fill fs-5 me-2 text-warning-emphasis mt-0.5"></i>
                    <div class="small text-warning-emphasis">
                        Pastikan Nomor Plat yang Anda masukkan adalah mobil yang sedang Anda sewa dan belum dikembalikan.
                    </div>
                </div>

                <form action="{{ route('rentals.processReturn') }}" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="form-label small fw-semibold text-dark">Nomor Plat Mobil</label>
                        <div class="input-group input-group-lg">
                            <span class="input-group-text bg-light text-muted"><i class="bi bi-card-heading"></i></span>
                            <input type="text" name="nomor_plat" class="form-control bg-light text-uppercase font-monospace fw-bold" placeholder="Contoh: B 1234 ABC" required style="letter-spacing: 1px;">
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-warning text-dark fw-bold py-2.5 rounded-3 shadow-sm">
                            <i class="bi bi-arrow-return-left me-1"></i> Proses Pengembalian
                        </button>
                        <a href="{{ route('rentals.index') }}" class="btn btn-light border text-secondary fw-semibold py-2 rounded-3">
                            Batal & Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection