<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
</head>
<body>
    <div class="card shadow-sm border-0">
    <div class="card-header bg-dark py-3">
        <h5 class="mb-0 fw-bold text-white">Riwayat Transaksi & Janji Temu</h5>
    </div>
    <div class="card-body p-0"> <div class="table-responsive">
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
                        <td class="ps-3"><code class="fw-bold text-primary">{{ $trx->transaction_code }}</code></td>
                        <td>
                            <div class="fw-bold">{{ $trx->user->name ?? 'Guest' }}</div>
                            <small class="text-muted">Layanan: {{ $trx->service->name ?? '-' }}</small>
                        </td>
                        <td>
                            <div class="small">{{ $trx->appointment_date->format('d/m/Y') }}</div>
                            <div class="small fw-bold">{{ $trx->appointment_date->format('H:i') }} WIB</div>
                        </td>
                        <td class="fw-bold text-success">
                            Rp {{ number_format($trx->total_price, 0, ',', '.') }}
                        </td>
                        <td>
                            @php
                                $color = [
                                    'cancelled' => 'danger',
                                    'success' => 'success',
                                    'pending' => 'warning'
                                ][$trx->status] ?? 'secondary';
                            @endphp
                            <span class="badge bg-{{ $color }} text-uppercase">{{ $trx->status }}</span>
                        </td>
                        <td class="text-end pe-3">
                            <button class="btn btn-sm btn-dark" title="Lihat Catatan" 
                                    data-bs-toggle="tooltip" data-bs-title="{{ $trx->user_notes }}">
                                <i class="bi bi-info-circle"></i> Detail
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>