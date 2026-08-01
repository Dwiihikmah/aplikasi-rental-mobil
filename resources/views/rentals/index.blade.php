@extends('layouts.app')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-2">
    <div>
        <h4 class="fw-bold text-dark mb-1"><i class="bi bi-clock-history me-2 text-primary"></i>Riwayat Penyewaan</h4>
        <p class="text-muted small mb-0">Daftar seluruh transaksi peminjaman mobil yang telah Anda lakukan</p>
    </div>
    <a href="{{ route('rentals.create') }}" class="btn btn-primary fw-semibold px-3 py-2 rounded-3 shadow-sm d-inline-flex align-items-center justify-content-center">
        <i class="bi bi-key me-1"></i> Sewa Mobil Baru
    </a>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-6 col-lg-4">
        <div class="card border-0 shadow-sm rounded-3 p-3">
            <div class="d-flex align-items-center">
                <div class="bg-warning-subtle text-warning-emphasis p-3 rounded-3 me-3">
                    <i class="bi bi-hourglass-split fs-3"></i>
                </div>
                <div>
                    <span class="text-muted small fw-semibold">Sedang Disewa</span>
                    <h4 class="fw-bold text-dark mb-0">{{ $rentals->where('status', 'rented')->count() }} Unit</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-4">
        <div class="card border-0 shadow-sm rounded-3 p-3">
            <div class="d-flex align-items-center">
                <div class="bg-success-subtle text-success-emphasis p-3 rounded-3 me-3">
                    <i class="bi bi-check-circle fs-3"></i>
                </div>
                <div>
                    <span class="text-muted small fw-semibold">Selesai Dikembalikan</span>
                    <h4 class="fw-bold text-dark mb-0">{{ $rentals->where('status', 'returned')->count() }} Transaksi</h4>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-3 overflow-hidden">
    <div class="card-header bg-white py-3 px-4 border-bottom d-flex justify-content-between align-items-center">
        <h6 class="card-title fw-bold mb-0 text-dark">Data Transaksi Saya</h6>
        <span class="badge bg-secondary-subtle text-secondary-emphasis fw-semibold px-3 py-1.5 rounded-pill">Total: {{ $rentals->count() }} Data</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-muted small text-uppercase">
                    <tr>
                        <th class="ps-4">Mobil</th>
                        <th>Nomor Plat</th>
                        <th>Periode Sewa</th>
                        <th>Total Biaya</th>
                        <th>Status</th>
                        <th class="text-center pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rentals as $rental)
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center">
                                <div class="bg-light text-secondary rounded-3 p-2 me-3">
                                    <i class="bi bi-car-front-fill fs-5"></i>
                                </div>
                                <div>
                                    <strong class="d-block text-dark">{{ $rental->car->merek }} {{ $rental->car->model }}</strong>
                                    <small class="text-muted">Rp {{ number_format($rental->car->tarif_per_hari, 0, ',', '.') }} / hari</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-dark-subtle text-dark border font-monospace px-2.5 py-1.5 fs-6 rounded-2">
                                {{ $rental->car->nomor_plat }}
                            </span>
                        </td>
                        <td>
                            <div class="small fw-semibold text-dark">
                                <i class="bi bi-calendar-event me-1 text-primary"></i>
                                {{ \Carbon\Carbon::parse($rental->start_date)->format('d M Y') }}
                            </div>
                            <div class="small text-muted">
                                s/d {{ \Carbon\Carbon::parse($rental->end_date)->format('d M Y') }}
                            </div>
                        </td>
                        <td>
                            @if($rental->status == 'returned')
                                <span class="fw-bold text-success fs-6">
                                    Rp {{ number_format($rental->total_cost, 0, ',', '.') }}
                                </span>
                            @else
                                <span class="text-muted small">-</span>
                            @endif
                        </td>
                        <td>
                            @if($rental->status == 'rented')
                                <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle px-3 py-1.5 rounded-pill fw-semibold">
                                    <i class="bi bi-hourglass-split me-1"></i> Sedang Disewa
                                </span>
                            @else
                                <span class="badge bg-success-subtle text-success-emphasis border border-success-subtle px-3 py-1.5 rounded-pill fw-semibold">
                                    <i class="bi bi-check-lg me-1"></i> Dikembalikan
                                </span>
                            @endif
                        </td>
                        <td class="text-center pe-4">
                            @if($rental->status == 'rented')
                                <a href="{{ route('rentals.return') }}" class="btn btn-sm btn-warning text-dark fw-semibold px-3 rounded-2 shadow-sm">
                                    <i class="bi bi-arrow-return-left me-1"></i> Kembalikan
                                </a>
                            @else
                                <span class="badge bg-light text-muted border px-3 py-1.5 rounded-2">Selesai</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="bi bi-calendar-x fs-2 text-secondary d-block mb-2 opacity-50"></i>
                            <span class="fw-semibold text-dark">Anda belum pernah menyewa mobil.</span>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection