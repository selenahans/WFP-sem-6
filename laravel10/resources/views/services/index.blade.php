@extends('layouts.adminlte4')
@section('title', 'SERVICES')
@section('content')
<div class="container-fluid mt-4">
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

        <div class="p-3 d-flex gap-2">
            <a href="{{ route('services.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Add Services
            </a>
            
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCreateService">
                <i class="bi bi-plus-circle"></i> Add Services (with Modal)
            </button>
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
                            <tr id="tr_{{ $service->id }}">
                                <td class="ps-3">
                                    <code class="fw-bold text-primary">#{{ $service->id }}</code>
                                </td>
                                <td id="td_main_info_{{ $service->id }}">
                                    <div class="fw-bold name-target">{{ $service->name }}</div>
                                    <small class="text-muted desc-target">{{ Str::limit($service->description, 50) }}</small>
                                </td>

                                <td id="td_category_{{ $service->id }}">
                                    <span class="badge bg-info text-dark cat-id-target">ID: {{ $service->category->id ?? '-' }}</span>
                                    <div class="small fw-bold text-capitalize cat-name-target">
                                        {{ $service->category->category_name ?? 'Tanpa Kategori' }}
                                    </div>
                                </td>
                                
                                <td id="td_price_{{ $service->id }}" class="fw-bold text-success">
                                    Rp {{ number_format($service->price, 0, ',', '.') }}
                                </td>

                                <td>
                                    @if($service->is_active ?? true)
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
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Hapus Layanan" 
                                                    onclick="return confirm('Are you sure to delete #{{ $service->id }} - {{ $service->name }}?');">
                                                <i class="bi bi-trash"></i> Delete
                                            </button>
                                        </form>

                                        <button type="button" class="btn btn-sm btn-info text-white fw-bold" data-bs-toggle="modal" data-bs-target="#modalEditService" onclick="getEditFormB({{ $service->id }})">
                                            Edit Ajax
                                        </button>

                                        <button type="button" class="btn btn-sm btn-dark fw-bold" onclick="deleteServiceRemove({{ $service->id }}, '{{ $service->name }}')">
                                            Delete Ajax
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push("script")
    <script>
        function getEditFormB(id) {
            $.ajax({
                type: 'POST',
                url: '{{ route("services.getEditFormB") }}',
                data: {
                    '_token': '{{ csrf_token() }}',
                    'id': id
                },
                beforeSend: function() {
                    $('#modalContentB').html('<div class="text-center py-3"><div class="spinner-border text-primary" role="status"></div></div>');
                },
                success: function (data) {
                    $('#modalContentB').html(data.msg);
                }
            });
        }

        function saveDataUpdate(id) {
            var name = $('#sname').val();
            var description = $('#sdescription').val();
            var category_id = $('#scategory_id').val();
            var price = $('#sprice').val();

            $.ajax({
                type: 'POST',
                url: '{{ route("services.saveDataUpdate") }}',
                data: {
                    '_token': '{{ csrf_token() }}',
                    'id': id,
                    'name': name,
                    'description': description,
                    'category_id': category_id,
                    'price': price
                },
                success: function(data) {
                    if (data.status == "oke") {
                        $('#td_main_info_' + id + ' .name-target').html(name);
                        $('#td_main_info_' + id + ' .desc-target').html(description.substring(0, 50));
                        $('#td_category_' + id + ' .cat-id-target').html('ID: ' + category_id);
                        $('#td_category_' + id + ' .cat-name-target').html(data.category_name);
                        $('#td_price_' + id).html(data.formatted_price);
                        
                        $('#modalEditService').modal('hide');
                        $('body').removeClass('modal-open');
                        $('.modal-backdrop').remove();
                    }
                }
            });
        }

        function deleteServiceRemove(id, name) {
            if (confirm("Are you sure to delete via Ajax #" + id + " - " + name + "?")) {
                $.ajax({
                    type: 'POST',
                    url: '{{ route("services.deleteData") }}',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'id': id
                    },
                    success: function(data) {
                        if (data.status == "oke") {
                            $('#tr_' + id).remove();
                        }
                    }
                });
            }
        }
    </script>
@endpush

@push('modals')
    <div class="modal fade" id="modalCreateService" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Add New Service</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('services.store') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Layanan</label>
                            <input type="text" name="name" class="form-control" required placeholder="Masukkan nama layanan...">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Deskripsi</label>
                            <textarea name="description" class="form-control" rows="3" required placeholder="Masukkan deskripsi layanan..."></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Tersedia Dari</label>
                                <input type="time" name="available_from" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Tersedia Sampai</label>
                                <input type="time" name="available_to" class="form-control" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Kategori</label>
                            <select name="category_id" class="form-select" required>
                                <option value="" disabled selected>-- Pilih Kategori --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Harga (Rupiah)</label>
                            <input type="number" name="price" class="form-control" required placeholder="Contoh: 150000">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEditService" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Edit Service Data (Ajax Type B)</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modalContentB">

                </div>
            </div>
        </div>
    </div>
@endpush