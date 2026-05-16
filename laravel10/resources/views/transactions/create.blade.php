@extends('layouts.adminlte4')

@section('title', 'CREATE TRANSACTION')

@section('content')
<div class="container-fluid mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-dark py-3">
            <h5 class="mb-0 fw-bold text-white">
                <i class="bi bi-cash-register me-2"></i> Form Input Transaksi Baru
            </h5>
        </div>
        
        <div class="card-body p-4">
            {{-- Form diarahkan ke method store pada TransactionController / Service --}}
            <form method="POST" action="{{ route('transaction.store') }}">
                @csrf

                <div class="form-group mb-3">
                    <label for="service_id" class="fw-bold">Pilih Layanan (Service ID)</label>
                    <select class="form-control form-select" id="service_id" name="service_id" required>
                        <option value="" disabled selected>-- Pilih Layanan dari Combo Box --</option>
                        {{-- Melakukan looping data $services yang dikirim dari method create() --}}
                        @foreach($services as $service)
                            <option value="{{ $service->id }}">
                                #{{ $service->id }} - {{ $service->name }} (Rp {{ number_format($service->price, 0, ',', '.') }})
                            </option>
                        @endforeach
                    </select>
                    <small class="form-text text-muted">
                        *Nilai ID Layanan diambil dari query database yang diparsing melalui method create().
                    </small>
                </div>

                <div class="form-group mb-3">
                    <label for="quantity" class="fw-bold">Jumlah Kuantitas (Each Number)</label>
                    <input type="number" class="form-control" id="quantity" name="quantity" min="1" value="1" required>
                    <small class="form-text text-muted">
                        Tentukan berapa banyak kuantitas layanan yang digunakan dalam transaksi ini.
                    </small>
                </div>

                <div class="form-group mb-3">
                    <label for="appointment_date" class="fw-bold">Jadwal Janji Temu (Appointment Date)</label>
                    <input type="datetime-local" class="form-control" id="appointment_date" name="appointment_date">
                </div>

                <div class="form-group mb-4">
                    <label for="user_notes" class="fw-bold">Catatan Pengguna (User Notes)</label>
                    <textarea class="form-control" id="user_notes" name="user_notes" rows="3" placeholder="Tulis catatan tambahan medis atau instruksi di sini..."></textarea>
                </div>

                <hr>

                <div class="d-flex justify-content-end mt-3">
                    <a href="{{ route('transaction.index') }}" class="btn btn-secondary me-2">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-check-circle"></i> Simpan Transaksi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection