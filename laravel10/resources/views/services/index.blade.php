@extends('layouts.adminlte4')
@section('title', 'SERVICES')
@section('content')
    <div class="card shadow-sm border-0">
        <div class="card-header bg-dark py-3">
            <h5 class="mb-0 fw-bold text-white">Daftar Layanan & Kategori</h5>
        </div>
        <div id="showInfo"></div>
        
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('status'))
            <div class="alert alert-warning alert-dismissible fade show m-3" role="alert">
                {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="p-3">
            <a href="{{ route('services.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Add Services
            </a>
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
                            <th class="text-end pe-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($services as $service)
                            <tr>
                                <td class="ps-3">
                                    <code class="fw-bold text-primary">#{{ $service->id }}</code>
                                </td>
                                <td>
                                    <div class="fw-bold">{{ $service->name }}</div>
                                    <small class="text-muted">{{ Str::limit($service->description, 50) }}</small>
                                </td>

                                <td>
                                    <span class="badge bg-info text-dark">ID: {{ $service->category->id ?? '-' }}</span>
                                    <div class="small fw-bold text-capitalize">
                                        {{ $service->category->category_name ?? 'Tanpa Kategori' }}
                                    </div>
                                </td>
                                
                                <td class="fw-bold text-success">
                                    Rp {{ number_format($service->price, 0, ',', '.') }}
                                </td>

                                <td>
                                    @if($service->is_active)
                                        <span class="badge bg-success">AKTIF</span>
                                    @else
                                        <span class="badge bg-danger">NON-AKTIF</span>
                                    @endif
                                </td>

                                <td class="text-end pe-3">
                                    <div class="d-flex justify-content-end gap-1">
                                        <a href="{{ route('services.show', $service->id) }}" class="btn btn-sm btn-dark" title="Detail Layanan">
                                            <i class="bi bi-eye"></i> Detail
                                        </a>

                                        <a href="{{ route('services.edit', $service->id) }}" class="btn btn-sm btn-warning text-dark fw-bold" title="Edit Layanan">
                                            <i class="bi bi-pencil"></i> Edit
                                        </a>

                                        <form method="POST" action="{{ route('services.destroy', $service->id) }}" class="d-inline">
                                            @csrf
                                            @method('DELETE') {{-- Mengubah spoofing method POST menjadi HTTP DELETE --}}
                                            
                                            <button type="submit" class="btn btn-sm btn-danger" title="Hapus Layanan" 
                                                    onclick="return confirm('Are you sure to delete #{{ $service->id }} - {{ $service->name }}?');">
                                                <i class="bi bi-trash"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection