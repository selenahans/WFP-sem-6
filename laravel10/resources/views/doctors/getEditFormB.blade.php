<div class="mb-3">
    <label for="dname" class="form-label">Nama Dokter</label>
    <input type="text" class="form-control" id="dname" value="{{ $data->name }}">
</div>

<div class="mb-3">
    <label for="dlicense" class="form-label">No. Izin Praktik</label>
    <input type="text" class="form-control" id="dlicense" value="{{ $data->license_number }}">
</div>

<div class="mb-3">
    <label for="dspecialist" class="form-label">Spesialisasi</label>
    <input type="text" class="form-control" id="dspecialist" value="{{ $data->specialist }}">
</div>

<div class="mb-3">
    <label for="dphone" class="form-label">No. Telepon</label>
    <input type="text" class="form-control" id="dphone" value="{{ $data->phone_number }}">
</div>

<div class="mb-3">
    <label for="dexperience" class="form-label">Pengalaman (Tahun)</label>
    <input type="number" class="form-control" id="dexperience" value="{{ $data->experience_years }}">
</div>

<div class="mb-3">
    <label for="dstatus" class="form-label">Status Aktivitas</label>
    <select class="form-select" id="dstatus">
        <option value="1" {{ $data->is_active == 1 ? 'selected' : '' }}>Aktif</option>
        <option value="0" {{ $data->is_active == 0 ? 'selected' : '' }}>Non-Aktif</option>
    </select>
</div>

<div class="text-end pt-2">
    <button type="button" class="btn btn-secondary me-1" data-bs-dismiss="modal">Batal</button>
<button type="button" onClick="saveDataUpdate({{ $data->id }})" class="btn btn-primary">Simpan Perubahan</button>
</div>