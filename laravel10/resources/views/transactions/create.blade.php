@extends('layouts.adminlte4')

@section('title', 'CREATE TRANSACTION')

@section('content')
<div class="container-fluid mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-dark py-3">
            <h5 class="mb-0 fw-bold text-white">
                <i class="bi bi-cash-register me-2"></i> Form Input Transaksi Baru (Many-to-Many)
            </h5>
        </div>
        
        <div class="card-body p-4">
            <form method="POST" action="{{ route('transaction.store') }}">
                @csrf

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label for="doctor_id" class="fw-bold">Pilih Dokter</label>
                        <select class="form-control form-select" id="doctor_id" name="doctor_id" required>
                            <option value="" disabled selected>-- Pilih Dokter --</option>
                            @foreach($doctors as $doctor)
                                <option value="{{ $doctor->id }}">{{ $doctor->name }} ({{ $doctor->specialist }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="appointment_date" class="fw-bold">Jadwal Janji Temu</label>
                        <input type="datetime-local" class="form-control" id="appointment_date" name="appointment_date" required>
                    </div>
                </div>

                <hr>

                <div class="mb-3">
                    <label class="fw-bold mb-2">Pilih Layanan & Kuantitas (Each Number)</label>
                    <div id="service-wrapper">
                        <div class="row g-2 mb-2 service-row">
                            <div class="col-md-7">
                                <select class="form-control form-select" name="services[]" required>
                                    <option value="" disabled selected>-- Pilih Layanan --</option>
                                    @foreach($services as $service)
                                        <option value="{{ $service->id }}">
                                            {{ $service->name }} (Rp {{ number_format($service->price, 0, ',', '.') }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <div class="input-group">
                                    <span class="input-group-text">Qty</span>
                                    <input type="number" class="form-control" name="quantities[]" min="1" value="1" required>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-outline-primary w-100 add-service">
                                    <i class="bi bi-plus-lg"></i> Tambah
                                </button>
                            </div>
                        </div>
                    </div>
                    <small class="form-text text-muted">
                        *Klik "Tambah" untuk memasukkan lebih dari satu layanan dalam satu transaksi (Many-to-Many).
                    </small>
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

<script>
    document.addEventListener('click', function (e) {
        if (e.target && e.target.classList.contains('add-service') || e.target.closest('.add-service')) {
            const wrapper = document.getElementById('service-wrapper');
            const newRow = document.querySelector('.service-row').cloneNode(true);
            newRow.querySelector('select').value = "";
            newRow.querySelector('input').value = "1";
            
            const button = newRow.querySelector('button');
            button.classList.replace('btn-outline-primary', 'btn-outline-danger');
            button.classList.replace('add-service', 'remove-service');
            button.innerHTML = '<i class="bi bi-trash"></i> Hapus';
            
            wrapper.appendChild(newRow);
        }

        if (e.target && e.target.classList.contains('remove-service') || e.target.closest('.remove-service')) {
            e.target.closest('.service-row').remove();
        }
    });
</script>
@endsection