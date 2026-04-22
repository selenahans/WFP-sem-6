@extends('layouts.adminlte4')
@section('title', 'CATEGORY')
@section('content')
<div class="container mt-5">
        <div class="card shadow border-0">
            <div class="card-header bg-dark py-3">
                <h5 class="mb-0 fw-bold text-white">Layanan Termahal per Kategori</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-secondary">
                            <tr>
                                <th class="ps-3">ID</th>
                                <th>Kategori</th>
                                <th>Layanan Termahal</th>
                                <th>Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $cat)
                                @php
                                    $mostExpensive = $cat->services->first();
                                @endphp
                                <tr>
                                    <td class="ps-3 text-muted">#{{ $cat->id }}</td>
                                    <td class="fw-bold">{{ $cat->category_name }}</td>
                                    <td>
                                        @if($mostExpensive)
                                            {{ $mostExpensive->name }}
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="text-success fw-bold">
                                        @if($mostExpensive)
                                            Rp {{ number_format($mostExpensive->price, 0, ',', '.') }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="mt-3">
            <small class="text-muted">* Jika layanan kosong, akan menampilkan "-"</small>
        </div>
    </div>
@endsection