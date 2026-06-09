<div class="mb-3">
    <label for="atitle" class="form-label fw-bold">Judul Artikel</label>
    <input type="text" class="form-control" id="atitle" value="{{ $data->title }}">
</div>

<div class="mb-3">
    <label for="acontent" class="form-label fw-bold">Konten / Isi Artikel</label>
    <textarea class="form-control" id="acontent" rows="6">{{ $data->content }}</textarea>
</div>

<div class="mb-3">
    <label for="astatus" class="form-label fw-bold">Status Penerbitan</label>
    <select class="form-select" id="astatus">
        <option value="published" {{ $data->status == 'published' ? 'selected' : '' }}>Published</option>
        <option value="draft" {{ $data->status == 'draft' ? 'selected' : '' }}>Draft</option>
    </select>
</div>

<div class="text-end pt-2">
    <button type="button" class="btn btn-secondary me-1" data-bs-dismiss="modal">Batal</button>
    <button type="button" onClick="saveDataUpdate({{ $data->id }})" class="btn btn-success">Simpan Perubahan</button>
</div>