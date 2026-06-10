@extends('layouts.adminlte4')
@section('title', 'CATEGORY')
@section('content')

    <div class="container-fluid mt-4">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Launch demo modal
        </button>
        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#btnFormModal">
            + New Category (with Modals)
        </button>

        <h2 class="mt-4">List of Categories</h2>
        <p>The <a href="#" onclick="showInfo()">.table</a> class adds basic styling (light padding and only horizontal
            dividers) to a table:</p>

        <div id="showInfo"></div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('status'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="mb-3">
            <a href="{{ route('category.create') }}" class="btn btn-primary">Add Category</a>
        </div>

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
                                <th>Gambar</th>
                                <th>List of services</th>
                                <th>Layanan Termahal</th>
                                <th>Harga</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $cat)
                                @php
                                    $mostExpensive = $cat->services->first();
                                @endphp
                                <tr id="tr_{{ $cat->id }}">
                                    <td class="ps-3 text-muted">#{{ $cat->id }}</td>
                                    {{-- <td class="fw-bold">{{ $cat->category_name }}</td> --}}
                                    <td id="td_name_{{ $cat->id }}">{{ $cat->category_name }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#imageModal-{{ $cat->id }}">
                                            Show
                                        </button>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal"
                                            data-bs-target="#detailModal" onclick="showDetail({{ $cat->id }})">
                                            Details
                                        </button>
                                    </td>
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
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('category.edit', $cat->id) }}"
                                                class='btn btn-sm btn-warning'>Edit</a>
                                                @can('delete-permission', Auth::user())
                                            <form method="POST" action="{{ route('category.destroy', $cat->id) }}"
                                                class="d-inline"
                                                onsubmit="return confirm('Are you sure to delete {{ $cat->id }} - {{ $cat->category_name }}?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                                
                                            </form>
                                            @endcan
                                            <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                                data-bs-target="#modalEditA" onclick="getEditForm({{ $cat->id }})">
                                                Edit Type A
                                            </button>
                                            <div class="d-flex gap-2">
                                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                    data-bs-target="#modalEditB" onclick="getEditFormB({{ $cat->id }})">
                                                    Edit Type B
                                                </button>
                                            </div>
                                            @can('delete-permission', Auth::user())
                                            <a href="#" value="DeleteNoReload" class="btn btn-danger"
                                                onclick="if(confirm('Are you sure to delete {{ $cat->id }} - {{ $cat->category_name }} ?')) deleteDataRemove({{ $cat->id }})">Delete
                                                without Reload</a>
                                                @endcan
                                        </div>
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

@push("script")

<script>
    function deleteDataRemove(id) {
        $.ajax({
            type: 'POST',
            url: '{{ route('category.deleteData') }}',
            data: {
                '_token': '<?php echo csrf_token(); ?>',
                'id': id
            },
            success: function(data) {
                if (data.status == "oke") {
                    $('#tr_' + id).remove();
                }
            }
        });
    }
</script>

    <script>
        function saveDataUpdate(id) {
            var name = $('#cname').val();

            console.log(name);
            $.ajax({
                type: 'POST',
                url: '{{ route("category.saveDataUpdate") }}',
                data: {
                    '_token': '<?php echo csrf_token(); ?>',
                    'id': id,
                    'name': name,
                },
                success: function (data) {
                    if (data.status == "oke") {
                        $('#td_name_' + id).html(name);
                        $('#modalEditB').modal('hide');
                    }
                }
            })
        }
        function showInfo() {
            $.ajax({
                type: 'POST',
                url: '{{ route("category.showInfo") }}',
                data: '_token=<?php echo csrf_token(); ?>',
                success: function (data) {
                    $('#showInfo').html(data.msg);
                }
            });
        }

        function showDetail(id) {
            $.ajax({
                type: 'POST',
                url: '{{ route("category.showListServices") }}',
                data: {
                    _token: '{{ csrf_token() }}',
                    idcat: id,
                },
                success: function (data) {
                    $('#detail-title').html(data.title);
                    $('#detail-body').html(data.body);
                }
            });
        }
        function getEditFormB(id) {
            $.ajax({
                type: 'POST',
                url: '{{ route("category.getEditFormB") }}',
                data: {
                    '_token': '<?php echo csrf_token(); ?>',
                    'id': id
                },
                beforeSend: function () {
                    $('#modalContentB').html('<div class="text-center py-3"><div class="spinner-border text-primary" role="status"></div></div>');
                },
                success: function (data) {
                    $('#modalContentB').html(data.msg);
                }
            });
        }
        function getEditForm(id) {
            $.ajax({
                type: 'POST',
                url: '{{ route("category.getEditForm") }}',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: id
                },
                beforeSend: function () {
                    $('#modalContent').html('<div class="text-center py-4"><div class="spinner-border text-primary" role="status"></div><p class="mt-2">Loading data...</p></div>');
                },
                success: function (data) {
                    $('#modalContent').html(data.msg);
                },
                error: function (xhr, status, error) {
                    let msg = 'Error: ' + status + ' — ' + error + '\n' + (xhr.responseText || 'No response');
                    $('#modalContent').html('<div class="alert alert-danger">' + msg + '</div>');
                }
            });
        }
    </script>
@endpush

@push ('modals')
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="btnFormModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add New Category</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('category.store') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="name" class="form-label">Name of Category</label>
                            <input type="text" name="name" class="form-control" id="name" required
                                placeholder="Enter name of category">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEditA" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="modalContent">

            </div>
        </div>
    </div>

    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="detail-title">List of Services</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="detail-body">
                   
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalEditB" tabindex="-1" role="basic" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Your Category</h4>
                </div>
                <div class="modal-body" id="modalContentB">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    @foreach($categories as $cat)
        <div class="modal fade" id="imageModal-{{ $cat->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Gambar untuk Kategori #{{$cat->id}}</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <h6 class="mb-3">{{ $cat->id }} - {{ $cat->category_name }}</h6>
                        @if($cat->image)
                            <img src="{{ asset('storage/' . $cat->image) }}" width="100%" class="img-fluid rounded"
                                style="max-height:250px; object-fit: cover;">
                        @else
                            <div class="alert alert-light">Tidak ada gambar untuk kategori ini.</div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endpush
