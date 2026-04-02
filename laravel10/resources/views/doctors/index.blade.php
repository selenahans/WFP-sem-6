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
        <h5 class="mb-0 fw-bold text-primary">Daftar Dokter</h5>
        <a href="#" class="btn btn-primary btn-sm px-3">Tambah Dokter</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="bg-light">
                    <tr>
                        <th>Photo</th>
                        <th>Info Dokter</th>
                        <th>Spesialis</th>
                        <th>No. Telepon</th>
                        <th>Pengalaman</th>
                        <th class="text-center">Status</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($doctors as $doctor)
                    <tr>
                        <td>
                            <img src="{{ asset('storage/'.$doctor->photo) }}" class="rounded shadow-sm" style="width: 50px; height: 50px; object-fit: cover;" alt="doctor">
                        </td>
                        <td>
                            <div class="fw-bold">{{ $doctor->name }}</div>
                            <small class="text-muted">{{ $doctor->license_number }}</small>
                        </td>
                        <td><span class="badge bg-info-soft text-info">{{ $doctor->specialist }}</span></td>
                        <td>{{ $doctor->phone_number }}</td>
                        <td>{{ $doctor->experience_years }} Tahun</td>
                        <td class="text-center">
                            @if($doctor->is_active)
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-secondary">Non-Aktif</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <button class="btn btn-sm btn-light border">Edit</button>
                            <button class="btn btn-sm btn-danger">Hapus</button>
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