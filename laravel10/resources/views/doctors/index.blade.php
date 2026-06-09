@extends('layouts.adminlte4')
@section('title', 'DOCTORS')
@section('content')
<div class="container-fluid mt-4">

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold text-primary">Daftar Dokter</h5>
            <button type="button" class="btn btn-primary btn-sm px-3" data-bs-toggle="modal" data-bs-target="#modalCreateDoctor">
                Tambah Dokter
            </button>
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
                        <tr id="tr_{{ $doctor->id }}">
                            <td>
                                <img src="{{ asset('storage/'.$doctor->photo) }}" class="rounded shadow-sm" style="width: 50px; height: 50px; object-fit: cover;" alt="doctor">
                            </td>
                            <td id="td_info_{{ $doctor->id }}">
                                <div class="fw-bold name-target">{{ $doctor->name }}</div>
                                <small class="text-muted license-target">{{ $doctor->license_number }}</small>
                            </td>
                            <td><span id="td_specialist_{{ $doctor->id }}" class="badge bg-info-soft text-info">{{ $doctor->specialist }}</span></td>
                            <td id="td_phone_{{ $doctor->id }}">{{ $doctor->phone_number }}</td>
                            <td id="td_experience_{{ $doctor->id }}">{{ $doctor->experience_years }} Tahun</td>
                            <td class="text-center" id="td_status_{{ $doctor->id }}">
                                @if($doctor->is_active)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Non-Aktif</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <button type="button" class="btn btn-sm btn-light border" data-bs-toggle="modal" data-bs-target="#modalEditDoctor" onclick="getEditFormB({{ $doctor->id }})">Edit</button>
                                <button type="button" class="btn btn-sm btn-danger" onclick="deleteDoctorRemove({{ $doctor->id }}, '{{ $doctor->name }}')">Hapus</button>
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
                url: '{{ route("doctor.getEditFormB") }}',
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
    var name = $('#dname').val();
    var license = $('#dlicense').val();
    var specialist = $('#dspecialist').val();
    var phone = $('#dphone').val();
    var exp = $('#dexperience').val();
    var status = $('#dstatus').val();

    $.ajax({
        type: 'POST',
        url: '{{ route("doctor.saveDataUpdate") }}',
        data: {
            '_token': '{{ csrf_token() }}',
            'id': id,
            'name': name,
            'license_number': license,
            'specialist': specialist,
            'phone_number': phone,
            'experience_years': exp,
            'is_active': status
        },
        success: function(data) {
            if (data.status == "oke") {
   
                $('#td_info_' + id + ' .name-target').html(name);
                $('#td_info_' + id + ' .license-target').html(license);
                $('#td_specialist_' + id).html(specialist);
                $('#td_phone_' + id).html(phone);
                $('#td_experience_' + id).html(exp + ' Tahun');
                
                if(status == 1) {
                    $('#td_status_' + id).html('<span class="badge bg-success">Aktif</span>');
                } else {
                    $('#td_status_' + id).html('<span class="badge bg-secondary">Non-Aktif</span>');
                }
                $('#modalEditDoctor').modal('hide');
                $('body').removeClass('modal-open'); 
                $('.modal-backdrop').remove(); 
            }
        }
    });
}


        function deleteDoctorRemove(id, name) {
            if (confirm("Apakah anda yakin ingin menghapus dokter " + name + "?")) {
                $.ajax({
                    type: 'POST',
                    url: '{{ route("doctor.deleteData") }}',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'id': id
                    },
                    success: function(data) {
                        if (data.status == "oke") {
                            $('#tr_' + id).remove(); 
                        }
                    },
                    error: function(xhr) {
                        alert(xhr.responseJSON.msg || "Terjadi kesalahan sistem.");
                    }
                });
            }
        }
    </script>
@endpush

@push('modals')
    <div class="modal fade" id="modalCreateDoctor" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Tambah Dokter Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('doctor.store') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama Dokter</label>
                            <input type="text" name="name" class="form-control" required placeholder="Contoh: dr. John Doe">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">No. Izin Praktik (License Number)</label>
                            <input type="text" name="license_number" class="form-control" required placeholder="Contoh: STR/12345/VI/2026">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Spesialisasi</label>
                            <input type="text" name="specialist" class="form-control" required placeholder="Contoh: Anak / Jantung">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">No. Telepon</label>
                            <input type="text" name="phone_number" class="form-control" required placeholder="Contoh: 081234567xx">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Pengalaman (Tahun)</label>
                            <input type="number" name="experience_years" class="form-control" required min="0" placeholder="Contoh: 5">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEditDoctor" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Ubah Data Dokter</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modalContentB">
                    </div>
            </div>
        </div>
    </div>
@endpush