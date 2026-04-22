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
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold text-success">Manajemen Konten</h5>
        <a href="#" class="btn btn-success btn-sm px-3">Buat Artikel Baru</a>
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
                    <tr>
                        <td>
                            <img src="{{ asset('storage/'.$article->image) }}" class="rounded" style="width: 60px; height: 40px; object-fit: cover;" alt="thumb">
                        </td>
                        <td>
                            <div class="text-truncate fw-bold" style="max-width: 300px;">{{ $article->title }}</div>
                            <small class="text-muted">Slug: {{ $article->slug }}</small>
                        </td>
                        <td>
                            <span class="badge {{ $article->status == 'published' ? 'bg-primary' : 'bg-warning' }}">
                                {{ ucfirst($article->status) }}
                            </span>
                        </td>
                        <td><i class="bi bi-eye"></i> {{ number_format($article->view_count) }}</td>
                        <td>{{ $article->created_at->format('d M Y') }}</td>
                        <td class="text-end">
                            <a href="#" class="btn btn-sm btn-outline-secondary">Edit</a>
                            <form action="#" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">Hapus</button>
                            </form>
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