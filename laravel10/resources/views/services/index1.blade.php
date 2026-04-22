<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Services</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

</head>

<body>
    <div class="card shadow-sm border-0">
        <div class="card-header bg-dark py-3">
            <h5 class="mb-0 fw-bold text-white">Daftar Layanan & Kategori</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th class="ps-3">ID Layanan</th>
                            <th>Nama Layanan</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Status</th>
                            <th class="text-end pe-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($services as $service)
                            <tr>
                                <td class="ps-3">
                                    <code class="fw-bold text-primary">#{{ $service->id }}</code>
                                </td>
                                <td>
                                    <div class="fw-bold">{{ $service->name }}
                                        <a href="{{ route('services.show', $service->id) }}" class="btn btn-sm btn-outline-primary ml-2">Detail</a>
                                    </div>
                                    <small class="text-muted">{{ Str::limit($service->description, 50) }}</small>
                                </td>

                                <td>
                                    <span class="badge bg-info text-dark">ID: {{ $service->category->id ?? '-' }}</span>
                                    <div class="small fw-bold text-capitalize">
                                        {{ $service->category->category_name ?? 'Tanpa Kategori' }}
                                    </div>
                                </td>
{{-- 
                                <td class="fw-bold text-success">
                                    Rp {{ number_format($service->price, 0, ',', '.') }}
                                </td> --}}

                                <td>
                                    @if($service->is_active)
                                        <span class="badge bg-success">AKTIF</span>
                                    @else
                                        <span class="badge bg-danger">NON-AKTIF</span>
                                    @endif
                                </td>

                                <td class="text-end pe-3">
                                    <button class="btn btn-sm btn-dark" title="Detail Layanan">
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
</body>

</html>

