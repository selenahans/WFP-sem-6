<!DOCTYPE html>
<html lang="en">

<head>
    <title>Detail Layanan - {{ $service->name }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <style>
        .service-card-detail {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            max-width: 800px;
            margin: auto;
        }
        .detail-img {
            height: 400px;
            object-fit: cover;
            width: 100%;
        }
    </style>
</head>

<body class="bg-light">

    <div class="container py-5">
        <div class="mb-4">
            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">← Kembali ke Daftar</a>
        </div>

        <div class="card service-card-detail shadow-sm border-0">
            <img src="https://images.unsplash.com/photo-1576091160550-2173dba999ef?ixlib=rb-1.2.1&auto=format&fit=crop&w=1000&q=80"
                class="detail-img" alt="{{ $service->name }}">

            <div class="card-body p-5">
                <div class="row">
                    <div class="col-md-8">
                        <small class="text-primary text-uppercase font-weight-bold">
                            {{ $service->category->category_name ?? 'General' }}
                        </small>
                        <h1 class="font-weight-bold mt-2" style="color: #2c3e50;">{{ $service->name }}</h1>
                        
                        <p class="text-muted mt-4" style="font-size: 1.1rem; line-height: 1.8;">
                            {{ $service->description }}
                        </p>

                        <div class="mt-4 p-3 bg-white border rounded" style="border-style: dashed !important;">
                            <h6 class="font-weight-bold mb-1"><i class="bi bi-clock"></i> Jam Operasional:</h6>
                            <p class="mb-0">
                                {{ date('H:i', strtotime($service->available_from)) }} -
                                {{ date('H:i', strtotime($service->available_to)) }} WIB
                            </p>
                        </div>
                    </div>

                    <div class="col-md-4 text-center border-left">
                        <div class="py-3">
                            <h5 class="text-muted">Biaya Layanan</h5>
                            <h2 class="text-success font-weight-bold mt-2">
                                Rp {{ number_format($service->price, 0, ',', '.') }}
                            </h2>
                            <button class="btn btn-dark btn-block btn-lg mt-4 shadow-sm">Pesan Sekarang</button>
                            <button class="btn btn-outline-secondary btn-block mt-2">Tanya Admin</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>