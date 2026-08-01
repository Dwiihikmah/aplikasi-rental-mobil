@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6 col-md-8">
        
        <div class="mb-3 text-center">
            <h4 class="fw-bold text-dark mb-1">Form Peminjaman Mobil</h4>
            <p class="text-muted small">Pilih kendaraan dan tentukan tanggal durasi sewa Anda</p>
        </div>

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-header bg-primary text-white px-4 py-3 border-0 d-flex align-items-center">
                <div class="bg-white text-primary p-2 rounded-3 me-3 d-inline-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                    <i class="bi bi-key-fill fs-5"></i>
                </div>
                <div>
                    <h6 class="mb-0 fw-bold">Isi Detail Pemesanan</h6>
                    <small class="text-white-50">Sistem akan memverifikasi ketersediaan mobil</small>
                </div>
            </div>

            <div class="card-body p-4">
                <form action="{{ route('rentals.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-dark">Pilih Kendaraan</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted"><i class="bi bi-car-front"></i></span>
                            <select name="car_id" class="form-select bg-light py-2" required>
                                <option value="" disabled selected>-- Pilih Mobil yang Tersedia --</option>
                                @foreach($cars as $car)
                                    <option value="{{ $car->id }}">
                                        {{ $car->merek }} {{ $car->model }} [{{ $car->nomor_plat }}] - Rp {{ number_format($car->tarif_per_hari, 0, ',', '.') }}/hari
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-dark">Tanggal Mulai Sewa</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-muted"><i class="bi bi-calendar-event"></i></span>
                                <input type="date" name="start_date" class="form-control bg-light py-2" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-dark">Tanggal Selesai Sewa</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-muted"><i class="bi bi-calendar-check"></i></span>
                                <input type="date" name="end_date" class="form-control bg-light py-2" required>
                            </div>
                        </div>
                    </div>

                    <div class="alert bg-body-tertiary border-0 rounded-3 p-3 mb-4">
                        <div class="d-flex align-items-center text-muted small">
                            <i class="bi bi-info-circle-fill me-2 text-primary fs-5"></i>
                            <span>Total biaya akan dihitung berdasarkan tarif harian dikali durasi hari saat pengembalian.</span>
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary py-2.5 fw-bold rounded-3 shadow-sm">
                            <i class="bi bi-check-circle-fill me-1"></i> Pesan Mobil Sekarang
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