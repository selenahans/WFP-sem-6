@extends('layouts.adminlte4')
@section('title', 'ARTICLES')
@section('content')
<div class="container mt-5">

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold text-success">Manajemen Konten</h5>
            <button type="button" class="btn btn-success btn-sm px-3" data-bs-toggle="modal" data-bs-target="#modalCreateArticle">
                Buat Artikel Baru
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="bg-light">
                        <tr>
                            <th>Image</th>
                            <th>Judul & Link</th>
                            <th>Status</th>
                            <th>Views</th>
                            <th>Dibuat</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($articles as $article)
                        <tr id="tr_{{ $article->id }}">
                            <td>
                                <img src="{{ asset('storage/'.$article->image) }}" class="rounded" style="width: 60px; height: 40px; object-fit: cover;" alt="thumb">
                            </td>
                            <td id="td_info_{{ $article->id }}">
                                <div class="text-truncate fw-bold title-target" style="max-width: 300px;">{{ $article->title }}</div>
                                <small class="text-muted slug-target">Slug: {{ $article->slug }}</small>
                            </td>
                            <td id="td_status_{{ $article->id }}">
                                <span class="badge {{ $article->status == 'published' ? 'bg-primary' : 'bg-warning' }} status-badge">
                                    {{ ucfirst($article->status) }}
                                </span>
                            </td>
                            <td><i class="bi bi-eye"></i> {{ number_format($article->view_count) }}</td>
                            <td>{{ $article->created_at->format('d M Y') }}</td>
                            <td class="text-end">
                                <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#modalEditArticle" onclick="getEditFormB({{ $article->id }})">Edit</button>
                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="deleteArticleRemove({{ $article->id }}, '{{ $article->title }}')">Hapus</button>
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
                url: '{{ route("article.getEditFormB") }}',
                data: {
                    '_token': '{{ csrf_token() }}',
                    'id': id
                },
                beforeSend: function() {
                    $('#modalContentB').html('<div class="text-center py-3"><div class="spinner-border text-success" role="status"></div></div>');
                },
                success: function (data) {
                    $('#modalContentB').html(data.msg);
                }
            });
        }

        function saveDataUpdate(id) {
            var title = $('#atitle').val();
            var content = $('#acontent').val();
            var status = $('#astatus').val();

            $.ajax({
                type: 'POST',
                url: '{{ route("article.saveDataUpdate") }}',
                data: {
                    '_token': '{{ csrf_token() }}',
                    'id': id,
                    'title': title,
                    'content': content,
                    'status': status
                },
                success: function(data) {
                    if (data.status == "oke") {
                        $('#td_info_' + id + ' .title-target').html(title);
                        $('#td_info_' + id + ' .slug-target').html('Slug: ' + title.toLowerCase().replace(/ /g, "-"));
                        
                        if(status == 'published') {
                            $('#td_status_' + id).html('<span class="badge bg-primary">Published</span>');
                        } else {
                            $('#td_status_' + id).html('<span class="badge bg-warning">Draft</span>');
                        }

                        $('#modalEditArticle').modal('hide');
                        $('body').removeClass('modal-open');
                        $('.modal-backdrop').remove();
                    }
                }
            });
        }

        function deleteArticleRemove(id, title) {
            if (confirm("Apakah anda yakin ingin menghapus artikel: \"" + title + "\"?")) {
                $.ajax({
                    type: 'POST',
                    url: '{{ route("article.deleteData") }}',
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
    <div class="modal fade" id="modalCreateArticle" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold text-success">Buat Artikel Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('article.store') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Judul Artikel</label>
                            <input type="text" name="title" class="form-control" required placeholder="Masukkan judul artikel...">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Konten / Isi Artikel</label>
                            <textarea name="content" class="form-control" rows="6" required placeholder="Tulis isi artikel di sini..."></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Status Penerbitan</label>
                            <select name="status" class="form-select" required>
                                <option value="published">Published</option>
                                <option value="draft">Draft</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Terbitkan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEditArticle" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold text-success">Ubah Konten Artikel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modalContentB">
                    </div>
            </div>
        </div>
    </div>
@endpush