@extends('layouts.app')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-2">
    <div>
        <h4 class="fw-bold text-dark mb-1"><i class="bi bi-car-front-fill me-2 text-primary"></i>Data Mobil</h4>
        <p class="text-muted small mb-0">Kelola dan pantau ketersediaan armada mobil yang disewakan</p>
    </div>
    <button type="button" class="btn btn-primary fw-semibold px-3 py-2 rounded-3 shadow-sm d-inline-flex align-items-center justify-content-center" data-bs-toggle="modal" data-bs-target="#addCarModal">
        <i class="bi bi-plus-lg me-1"></i> Tambah Mobil Baru
    </button>
</div>

<div class="card border-0 shadow-sm rounded-3 mb-4">
    <div class="card-body p-3">
        <form method="GET" action="{{ route('cars.index') }}" class="row g-2 align-items-center">
            <div class="col-md-7">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" class="form-control bg-light border-start-0" placeholder="Cari berdasarkan merek atau model..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-check form-switch ms-2 py-1">
                    <input class="form-check-input" type="checkbox" role="switch" name="available" value="1" id="availCheck" {{ request('available') ? 'checked' : '' }}>
                    <label class="form-check-label text-secondary small fw-semibold" for="availCheck">
                        Hanya yang tersedia
                    </label>
                </div>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-dark w-100 fw-semibold rounded-3">Filter</button>
            </div>
        </form>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-3 overflow-hidden">
    <div class="card-header bg-white py-3 px-4 border-bottom d-flex justify-content-between align-items-center">
        <h6 class="card-title fw-bold mb-0 text-dark">Daftar Kendaraan Terdaftar</h6>
        <span class="badge bg-primary-subtle text-primary fw-semibold px-3 py-1.5 rounded-pill">Total: {{ $cars->count() }} Mobil</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-muted small text-uppercase">
                    <tr>
                        <th class="ps-4" style="width: 5%;">No</th>
                        <th>Merek & Model</th>
                        <th>Nomor Plat</th>
                        <th>Tarif Sewa Harian</th>
                        <th>Status</th>
                        <th class="text-end pe-4" style="width: 15%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($cars as $index => $car)
                    @php
                        $isRented = $car->rentals()->where('status', 'rented')->exists();
                    @endphp
                    <tr>
                        <td class="ps-4 fw-semibold text-secondary">{{ $index + 1 }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="bg-primary-subtle text-primary rounded-3 p-2 me-3">
                                    <i class="bi bi-car-front fs-5"></i>
                                </div>
                                <div>
                                    <span class="fw-bold text-dark d-block">{{ $car->merek }}</span>
                                    <small class="text-muted">{{ $car->model }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-dark-subtle text-dark border font-monospace px-2.5 py-1.5 fs-6 rounded-2">
                                {{ $car->nomor_plat }}
                            </span>
                        </td>
                        <td>
                            <span class="fw-bold text-success fs-6">
                                Rp {{ number_format($car->tarif_per_hari, 0, ',', '.') }}
                            </span>
                            <small class="text-muted">/ hari</small>
                        </td>
                        <td>
                            @if($isRented)
                                <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle px-3 py-1.5 rounded-pill fw-semibold">
                                    <i class="bi bi-hourglass-split me-1"></i> Sedang Disewa
                                </span>
                            @else
                                <span class="badge bg-success-subtle text-success-emphasis border border-success-subtle px-3 py-1.5 rounded-pill fw-semibold">
                                    <i class="bi bi-check-circle-fill me-1"></i> Tersedia
                                </span>
                            @endif
                        </td>
                        <td class="text-end pe-4">
                            <div class="d-flex justify-content-end align-items-center gap-1">
                                <button type="button" class="btn btn-sm btn-warning text-dark fw-semibold rounded-2 px-2 py-1" data-bs-toggle="modal" data-bs-target="#editCarModal{{ $car->id }}" title="Edit">
                                    <i class="bi bi-pencil-square me-1"></i> Edit
                                </button>
                                <button type="button" class="btn btn-sm btn-danger text-white fw-semibold rounded-2 px-2 py-1" data-bs-toggle="modal" data-bs-target="#deleteCarModal{{ $car->id }}" title="Hapus">
                                    <i class="bi bi-trash me-1"></i> Hapus
                                </button>
                            </div>
                        </td>
                    </tr>

                    <div class="modal fade" id="editCarModal{{ $car->id }}" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content border-0 shadow rounded-4 overflow-hidden">
                                <div class="modal-header bg-warning text-dark px-4 py-3">
                                    <h5 class="modal-title fw-bold fs-6"><i class="bi bi-pencil-square me-2"></i>Edit Data Mobil</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form action="{{ route('cars.update', $car->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body p-4 text-start">
                                        <div class="mb-3">
                                            <label class="form-label small fw-semibold text-dark">Merek Mobil</label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-light text-muted"><i class="bi bi-tag"></i></span>
                                                <input type="text" name="merek" class="form-control" value="{{ old('merek', $car->merek) }}" required>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label small fw-semibold text-dark">Model Mobil</label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-light text-muted"><i class="bi bi-car-front"></i></span>
                                                <input type="text" name="model" class="form-control" value="{{ old('model', $car->model) }}" required>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label small fw-semibold text-dark">Nomor Plat</label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-light text-muted"><i class="bi bi-card-heading"></i></span>
                                                <input type="text" name="nomor_plat" class="form-control text-uppercase font-monospace" value="{{ old('nomor_plat', $car->nomor_plat) }}" required>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label small fw-semibold text-dark">Tarif Sewa Harian (Rp)</label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-light fw-bold text-muted">Rp</span>
                                                <input type="number" name="tarif_per_hari" class="form-control" value="{{ old('tarif_per_hari', $car->tarif_per_hari) }}" min="0" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer bg-light px-4 py-3 border-top-0">
                                        <button type="button" class="btn btn-secondary rounded-3" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-warning fw-bold rounded-3 px-4">
                                            <i class="bi bi-save me-1"></i> Perbarui Data
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="deleteCarModal{{ $car->id }}" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered modal-sm">
                            <div class="modal-content border-0 shadow rounded-4 overflow-hidden">
                                <div class="modal-body p-4 text-center">
                                    <i class="bi bi-exclamation-triangle-fill text-danger fs-1 mb-2 d-block"></i>
                                    <h6 class="fw-bold text-dark mb-2">Hapus Mobil Ini?</h6>
                                    <p class="text-muted small mb-3">
                                        Anda yakin ingin menghapus <strong>{{ $car->merek }} {{ $car->model }}</strong> ({{ $car->nomor_plat }})?
                                    </p>
                                    <form action="{{ route('cars.destroy', $car->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <div class="d-flex justify-content-center gap-2">
                                            <button type="button" class="btn btn-light border px-3 rounded-3" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-danger fw-bold px-3 rounded-3">Hapus</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="bi bi-inbox fs-2 text-secondary d-block mb-2 opacity-50"></i>
                            <span class="fw-semibold text-dark">Belum ada data mobil.</span><br>
                            <small>Klik tombol <strong>+ Tambah Mobil Baru</strong> untuk menambahkan unit.</small>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="addCarModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4 overflow-hidden">
            <div class="modal-header bg-primary text-white px-4 py-3">
                <h5 class="modal-title fw-bold fs-6"><i class="bi bi-plus-circle me-2"></i>Tambah Mobil Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('cars.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-dark">Merek Mobil</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted"><i class="bi bi-tag"></i></span>
                            <input type="text" name="merek" class="form-control" placeholder="Contoh: Toyota, Honda" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-dark">Model Mobil</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted"><i class="bi bi-car-front"></i></span>
                            <input type="text" name="model" class="form-control" placeholder="Contoh: Avanza, Civic" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-dark">Nomor Plat</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted"><i class="bi bi-card-heading"></i></span>
                            <input type="text" name="nomor_plat" class="form-control text-uppercase font-monospace" placeholder="Contoh: B 1234 CD" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-dark">Tarif Sewa Harian (Rp)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light fw-bold text-muted">Rp</span>
                            <input type="number" name="tarif_per_hari" class="form-control" placeholder="300000" min="0" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light px-4 py-3 border-top-0">
                    <button type="button" class="btn btn-secondary rounded-3" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary fw-bold rounded-3 px-4">
                        <i class="bi bi-save me-1"></i> Simpan Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection