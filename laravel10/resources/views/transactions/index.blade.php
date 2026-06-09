@extends('layouts.adminlte4')
@section('title', 'TRANSACTIONS')
@section('content')
<div class="container-fluid mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-dark py-3">
            <h5 class="mb-0 fw-bold text-white">Riwayat Transaksi & Janji Temu</h5>
        </div>
        <div id="showInfo"></div>
        
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="p-3">
            <a href="{{ route('transactions.create') }}" class="btn btn-primary">Add Transaction</a>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th class="ps-3">Kode</th>
                            <th>Pasien & Layanan</th>
                            <th>Jadwal</th>
                            <th>Total Harga</th>
                            <th>Status</th>
                            <th class="text-end pe-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transactions as $trx)
                            <tr id="tr_{{ $trx->id }}">
                                <td class="ps-3">
                                    <code class="fw-bold text-primary">{{ $trx->transaction_code }}</code>
                                </td>
                                <td>
                                    <div class="fw-bold">{{ $trx->user->name ?? 'Guest' }}</div>
                                    <small class="text-muted d-block" id="td_services_list_{{ $trx->id }}">
                                        Layanan:
                                        @if($trx->services->isNotEmpty())
                                            @foreach($trx->services as $service)
                                                <span class="badge bg-secondary text-white mb-1 badge-service-item">
                                                    {{ $service->name }} ({{ $service->pivot->quantity }}x)
                                                </span>
                                            @endforeach
                                        @else
                                            {{ $trx->service->name ?? '-' }}
                                        @endif
                                    </small>
                                </td>
                                <td id="td_schedule_{{ $trx->id }}">
                                    <div class="small date-target">{{ $trx->appointment_date ? $trx->appointment_date->format('d/m/Y') : '-' }}</div>
                                    <div class="small fw-bold text-muted time-target">{{ $trx->appointment_date ? $trx->appointment_date->format('H:i') . ' WIB' : '' }}</div>
                                </td>
                                <td id="td_price_{{ $trx->id }}" class="fw-bold text-success">
                                    Rp {{ number_format($trx->total_price, 0, ',', '.') }}
                                </td>
                                <td id="td_status_{{ $trx->id }}">
                                    @php
                                        $color = ['cancelled'=>'danger','completed'=>'success','success'=>'success','pending'=>'warning'][$trx->status] ?? 'secondary';
                                    @endphp
                                    <span class="badge bg-{{ $color }} text-uppercase">{{ $trx->status }}</span>
                                </td>
                                <td class="text-end pe-3">
                                    <div class="d-flex justify-content-end gap-1">
                                        <a href="{{ route('transactions.edit', $trx->id) }}" class="btn btn-sm btn-warning text-dark fw-bold">
                                            <i class="bi bi-pencil"></i> Edit
                                        </a>
                                        <form method="POST" action="{{ route('transactions.destroy', $trx->id) }}" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin?')">
                                                <i class="bi bi-trash"></i> Delete
                                            </button>
                                        </form>

                                        <button type="button" class="btn btn-sm btn-info text-white fw-bold" data-bs-toggle="modal" data-bs-target="#modalEditTransaction" onclick="getEditFormB({{ $trx->id }})">
                                            Edit Ajax
                                        </button>
                                        <button type="button" class="btn btn-sm btn-dark fw-bold" onclick="deleteTransactionRemove({{ $trx->id }}, '{{ $trx->transaction_code }}')">
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
            url: '{{ route("transactions.getEditFormB") }}',
            data: { 
                '_token': '{{ csrf_token() }}', 
                'id': id 
            },
            beforeSend: function() { 
                $('#modalContentB').html('<div class="text-center py-3"><div class="spinner-border" role="status"></div></div>'); 
            },
            success: function (data) { 
                $('#modalContentB').html(data.msg); 
            }
        });
    }

    function saveDataUpdate(id) {
        var services = [];
        var quantities = {};
        

        $("input[name='services[]']:checked").each(function() { 
            var serviceId = $(this).val();
            services.push(serviceId);

            quantities[serviceId] = $('#qty_' + serviceId).val();
        });

        if(services.length === 0) {
            alert('Pilih minimal satu layanan!');
            return;
        }

        $.ajax({
            type: 'POST',
            url: '{{ route("transactions.saveDataUpdate") }}',
            data: {
                '_token': '{{ csrf_token() }}',
                'id': id,
                'doctor_id': $('#tdoctor_id').val(),
                'appointment_date': $('#tappointment_date').val(),
                'user_notes': $('#tuser_notes').val(),
                'status': $('#tstatus').val(),
                'services': services,
                'quantities': quantities
            },
            success: function(data) {
                if (data.status == "oke") {

                    $('#tr_' + id + ' .date-target').html(data.formatted_date);
                    $('#tr_' + id + ' .time-target').html(data.formatted_time);
                    $('#td_price_' + id).html(data.formatted_price);
                    
                    var color = data.trx_status == 'pending' ? 'warning' : (data.trx_status == 'cancelled' ? 'danger' : 'success');
                    $('#td_status_' + id).html('<span class="badge bg-' + color + ' text-uppercase">' + data.trx_status + '</span>');
                    $('#modalEditTransaction').modal('hide');
                    $('body').removeClass('modal-open');
                    $('.modal-backdrop').remove();
                
                    location.reload();
                }
            },
            error: function(xhr) {
                alert("Gagal menyimpan data: " + xhr.responseJSON.msg);
            }
        });
    }
    function deleteTransactionRemove(id, code) {
        if (confirm("Apakah Anda yakin ingin menghapus transaksi " + code + " secara Ajax?")) {
            $.ajax({
                type: 'POST',
                url: '{{ route("transactions.deleteData") }}',
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
<div class="modal fade" id="modalEditTransaction" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Ubah Transaksi / Janji Temu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modalContentB">
            </div>
        </div>
    </div>
</div>
@endpush