@extends('layouts.adminlte4')

@section('title', 'TRANSACTIONS')

@section('content')
    <div class="card shadow-sm border-0">
        <div class="card-header bg-dark py-3">
            <h5 class="mb-0 fw-bold text-white">Riwayat Transaksi & Janji Temu</h5>
        </div>
        <div id="showInfo"></div>
        @if (@session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <a href="{{ route('transactions.create') }}" class="btn btn-primary">Add Transaction</a>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th class="ps-3">Kode</th>
                            <th>Pasien & Layanan</th>
                            <th>Jadwal</th>
                            <th>Total Harga</th>
                            <th>Status</th>
                            <th class="text-end pe-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transactions as $trx)
                            <tr>
                                <td class="ps-3">
                                    <code class="fw-bold text-primary">{{ $trx->transaction_code }}</code>
                                </td>

                                <td>
                                    <div class="fw-bold">{{ $trx->user->name ?? 'Guest' }}</div>
                                    <small class="text-muted d-block">
                                        Layanan:
                                        @if($trx->services->isNotEmpty())
                                            @foreach($trx->services as $service)
                                                <span class="badge bg-secondary text-white">
                                                    {{ $service->name }} ({{ $service->pivot->quantity }}x)
                                                </span>
                                            @endforeach
                                        @else
                                            {{ $trx->service->name ?? '-' }}
                                        @endif
                                    </small>
                                </td>

                                <td>
                                    <div class="small">
                                        {{ $trx->appointment_date ? $trx->appointment_date->format('d/m/Y') : '-' }}</div>
                                    <div class="small fw-bold text-muted">
                                        {{ $trx->appointment_date ? $trx->appointment_date->format('H:i') . ' WIB' : '' }}
                                    </div>
                                </td>

                                <td class="fw-bold text-success">
                                    Rp {{ number_format($trx->total_price, 0, ',', '.') }}
                                </td>

                                <td>
                                    @php
                                        $color = [
                                            'cancelled' => 'danger',
                                            'completed' => 'success',
                                            'success' => 'success',
                                            'pending' => 'warning'
                                        ][$trx->status] ?? 'secondary';
                                    @endphp
                                    <span class="badge bg-{{ $color }} text-uppercase">{{ $trx->status }}</span>
                                </td>

                                <td class="text-end pe-3">
                                    <button class="btn btn-sm btn-dark" title="Lihat Catatan" data-bs-toggle="tooltip"
                                        data-bs-title="{{ $trx->user_notes ?? 'Tidak ada catatan' }}">
                                        <i class="bi bi-eye"></i> Detail
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection