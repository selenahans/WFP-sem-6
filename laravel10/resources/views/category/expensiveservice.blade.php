@extends('layouts.adminlte4')
@section('title', 'CATEGORY')
@section('content')
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
        Launch demo modal
    </button>
    <h2>List of Categories</h2>
    <p>The <a href="#" onclick="showInfo()">.table</a> class adds basic styling (light padding and only horizontal dividers)
        to a table:</p>
    <div id="showInfo"></div>
        @if (@session('success'))
        <div class="alert alert-success">
           {{ session('success') }}
        </div>
        @endif
        @if (session('status'))
        <div class="alert alert-warning">
            {{ session('status') }}
        </div>       
        @endif
    <a href="{{ route('category.create') }}" class="btn btn-primary">Add Category</a>
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
                                <tr>
                                    <td class="ps-3 text-muted">#{{ $cat->id }}</td>
                                    <td class="fw-bold">{{ $cat->category_name }}</td>
                                    <td>
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#imageModal-{{ $cat->id }}">
                                            Show
                                        </button>
                                        @push ('modal')
                                            <!-- Modal {{ $cat->id }} -->
                                            <div class="modal fade" id="imageModal-{{ $cat->id }}" tabindex="-1"
                                                aria-labelledby="imageModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="imageModalLabel">Gambar untuk Kategori
                                                                {{$cat->id}}
                                                            </h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            {{ $cat->id }} - {{ $cat->category_name }}
                                                            <img src="{{ asset('storage/' . $cat->image) }}" width="100%"
                                                                class="img-responsive" style="max-height:250px;" src="#">
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Close</button>
                                                            <button type="button" class="btn btn-primary">Save changes</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endpush

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
                                        {{-- {{ $cat->list_of_services ?? '-' }} --}}
                                        <button type="button" class="btn btn-info" data-bs-toggle="modal"
                                            data-bs-target="#detailModal" onclick="showDetail({{ $cat->id }})">
                                            Details
                                        </button>

                                    </td>
                                    @push ('modal')
                                        <!-- Modal -->
                                        <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel"
                                            aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="detail-title">List of </h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body" id="detail-body">
                                                        <ul>
                                                            @foreach ($cat->services as $f)
    <li>{{ $f->service_name }}</li>
@endforeach
                                                        </ul>

                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endpush

      <td>
    <a href="{{ route('category.edit', $cat->id) }}" class='btn btn-warning'>Edit</a>
    <form method="POST" action="{{ route('category.destroy', $cat->id) }}">
        @csrf
        @method('DELETE')
        <input type="submit" value="Delete" class="btn btn-danger"
        onclick="return confirm('Are you sure to delete {{ $cat->id }} - {{ $cat->name }}?');">
    </form>
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
    @push("script")

        <script>
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
                    url: '{{ route("category.showListServices") }}’,
                        data: {
                        '_token': '<?php echo csrf_token(); ?>',
                        'idcat': id,
                    },
                    success: function (data) {
                        $('#detail-title').html(data.title);
                        $('#detail-body').html(data.body);
                    }
                });
            }


        </script>
    @endpush


    @push ('modals')
        <!-- Modal -->
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
    @endpush

@endsection