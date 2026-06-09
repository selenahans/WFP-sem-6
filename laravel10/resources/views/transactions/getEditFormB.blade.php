<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label fw-bold">Dokter Pendamping</label>
        <select class="form-select" id="tdoctor_id">
            @foreach($doctors as $doctor)
                <option value="{{ $doctor->id }}" {{ $transaction->doctor_id == $doctor->id ? 'selected' : '' }}>
                    {{ $doctor->name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label fw-bold">Jadwal Janji Temu</label>
        <input type="datetime-local" class="form-control" id="appointment_date_raw" 
               value="{{ $transaction->appointment_date ? $transaction->appointment_date->format('Y-m-d\TH:i') : '' }}">
        <input type="hidden" id="tappointment_date" 
               value="{{ $transaction->appointment_date ? $transaction->appointment_date->format('Y-m-d H:i:s') : '' }}">
    </div>
</div>

<div class="mb-3">
    <label class="form-label fw-bold">Status Transaksi</label>
    <select class="form-select" id="tstatus">
        <option value="pending" {{ $transaction->status == 'pending' ? 'selected' : '' }}>PENDING</option>
        <option value="completed" {{ $transaction->status == 'completed' ? 'selected' : '' }}>COMPLETED</option>
        <option value="cancelled" {{ $transaction->status == 'cancelled' ? 'selected' : '' }}>CANCELLED</option>
    </select>
</div>

<div class="mb-3">
    <label class="form-label fw-bold">Pilihan Layanan Medis</label>
    <div class="card p-3 bg-light border-0">
        @foreach($services as $service)
            @php
                $isChecked = array_key_exists($service->id, $selectedServices);
                $qtyValue = $isChecked ? $selectedServices[$service->id] : 1;
            @endphp
            <div class="d-flex align-items-center justify-content-between mb-2">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="services[]" value="{{ $service->id }}" id="chk_{{ $service->id }}" {{ $isChecked ? 'checked' : '' }}>
                    <label class="form-check-label fw-semibold" for="chk_{{ $service->id }}">
                        {{ $service->name }} <span class="text-success small">(Rp {{ number_format($service->price, 0, ',', '.') }})</span>
                    </label>
                </div>
                <div style="width: 90px;">
                    <input type="number" class="form-control form-control-sm text-center" id="qty_{{ $service->id }}" value="{{ $qtyValue }}" min="1">
                </div>
            </div>
        @endforeach
    </div>
</div>

<div class="mb-3">
    <label for="tuser_notes" class="form-label fw-bold">Catatan Keluhan</label>
    <textarea class="form-control" id="tuser_notes" rows="2">{{ $transaction->user_notes }}</textarea>
</div>

<div class="text-end pt-2">
    <button type="button" class="btn btn-secondary me-1" data-bs-dismiss="modal">Batal</button>
    <button type="button" onClick="saveDataUpdate({{ $transaction->id }})" class="btn btn-primary">Simpan Perubahan</button>
</div>

<script>
    
    $('#appointment_date_raw').on('change', function() {
        var rawVal = $(this).val();
        if(rawVal) {
            $('#tappointment_date').val(rawVal.replace('T', ' ') + ':00');
        }
    });
</script>