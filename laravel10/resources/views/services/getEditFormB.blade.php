<div class="mb-3">
    <label for="sname" class="form-label fw-bold">Nama Layanan</label>
    <input type="text" class="form-control" id="sname" value="{{ $data->name }}">
</div>

<div class="mb-3">
    <label for="sdescription" class="form-label fw-bold">Deskripsi</label>
    <textarea class="form-control" id="sdescription" rows="3">{{ $data->description }}</textarea>
</div>

<div class="mb-3">
    <label for="scategory_id" class="form-label fw-bold">Kategori</label>
    <select class="form-select" id="scategory_id">
        @foreach($categories as $category)
            <option value="{{ $category->id }}" {{ $data->category_id == $category->id ? 'selected' : '' }}>
                {{ $category->category_name }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label for="sprice" class="form-label fw-bold">Harga</label>
    <input type="number" class="form-control" id="sprice" value="{{ $data->price }}">
</div>

<div class="text-end pt-2">
    <button type="button" class="btn btn-secondary me-1" data-bs-dismiss="modal">Batal</button>
    <button type="button" onClick="saveDataUpdate({{ $data->id }})" class="btn btn-primary">Simpan Perubahan</button>
</div>