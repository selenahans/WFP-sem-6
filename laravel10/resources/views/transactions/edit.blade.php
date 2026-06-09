@extends('layouts.adminlte4')

@section('title', 'EDIT TRANSACTION')

@section('content')
    <div class="container-fluid mt-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-warning py-3">
                <h5 class="mb-0 fw-bold text-dark">
                    <i class="bi bi-pencil-square me-2"></i> Form Edit Transaksi: {{ $transaction->transaction_code }}
                </h5>
            </div>

            <div class="card-body p-4">

                @if ($errors->any())
                    <div class="alert alert-danger pb-0">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('status'))
                    <div class="alert alert-danger">{{ session('status') }}</div>
                @endif

                <form method="POST" action="{{ route('transactions.update', $transaction->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="doctor_id" class="fw-bold">Pilih Dokter</label>
                            <select class="form-control form-select" id="doctor_id" name="doctor_id" required>
                                @foreach($doctors as $doctor)
                                    <option value="{{ $doctor->id }}" {{ old('doctor_id', $transaction->doctor_id) == $doctor->id ? 'selected' : '' }}>
                                        {{ $doctor->name }} ({{ $doctor->specialist }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="appointment_date" class="fw-bold">Jadwal Janji Temu</label>
                            <input type="datetime-local" class="form-control" id="appointment_date" name="appointment_date"
                                value="{{ old('appointment_date', $transaction->appointment_date ? $transaction->appointment_date->format('Y-m-d\TH:i') : '') }}"
                                required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="status" class="fw-bold">Status Transaksi</label>
                            <select class="form-control form-select" id="status" name="status" required>
                                <option value="pending" {{ old('status', $transaction->status) == 'pending' ? 'selected' : '' }}>PENDING</option>
                                <option value="completed" {{ old('status', $transaction->status) == 'completed' ? 'selected' : '' }}>COMPLETED</option>
                                <option value="cancelled" {{ old('status', $transaction->status) == 'cancelled' ? 'selected' : '' }}>CANCELLED</option>
                            </select>
                        </div>
                    </div>

                    <hr>

                    <div class="mb-3">
                        <label class="fw-bold mb-2">Layanan & Kuantitas Terpilih</label>
                        <div id="service-wrapper">
                            @if($transaction->services->isNotEmpty())
                                {{-- Jika data relasi ada di database, looping semuanya --}}
                                @foreach($transaction->services as $index => $selectedService)
                                    <div class="row g-2 mb-2 service-row">
                                        <div class="col-md-7">
                                            <select class="form-control form-select" name="services[]" required>
                                                @foreach($services as $service)
                                                    <option value="{{ $service->id }}" {{ $selectedService->id == $service->id ? 'selected' : '' }}>
                                                        {{ $service->name }} (Rp {{ number_format($service->price, 0, ',', '.') }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group">
                                                <span class="input-group-text">Qty</span>
                                                <input type="number" class="form-control" name="quantities[]" min="1"
                                                    value="{{ $selectedService->pivot->quantity }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            @if($index == 0)
                                                <button type="button" class="btn btn-outline-primary w-100 add-service">
                                                    <i class="bi bi-plus-lg"></i> Tambah
                                                </button>
                                            @else
                                                <button type="button" class="btn btn-outline-danger w-100 remove-service">
                                                    <i class="bi bi-trash"></i> Hapus
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                {{-- FALLBACK (Baru): Jika data kosong, tampilkan 1 baris default agar user bisa memilih layanan
                                --}}
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
                                            <input type="number" class="form-control" name="quantities[]" min="1" value="1"
                                                required>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-outline-primary w-100 add-service">
                                            <i class="bi bi-plus-lg"></i> Tambah
                                        </button>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <label for="user_notes" class="fw-bold">Catatan Pengguna (User Notes)</label>
                        <textarea class="form-control" id="user_notes" name="user_notes"
                            rows="3">{{ old('user_notes', $transaction->user_notes) }}</textarea>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-end mt-3">
                        <a href="{{ route('transactions.index') }}" class="btn btn-secondary me-2">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-warning text-dark fw-bold px-4">
                            <i class="bi bi-check-circle"></i> Perbarui Transaksi
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
                const firstRow = document.querySelector('.service-row');
                const newRow = firstRow.cloneNode(true);

                newRow.querySelector('select').selectedIndex = 0;
                newRow.querySelector('input').value = "1";

                const button = newRow.querySelector('button');
                button.className = 'btn btn-outline-danger w-100 remove-service';
                button.innerHTML = '<i class="bi bi-trash"></i> Hapus';

                wrapper.appendChild(newRow);
            }

            if (e.target && e.target.classList.contains('remove-service') || e.target.closest('.remove-service')) {
                e.target.closest('.service-row').remove();
            }
        });
    </script>
@endsection