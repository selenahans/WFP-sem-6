<h3>Update Category</h3>
{{-- <form method="POST" action="{{ route('category.update', $data->id) }}"> --}}
    @csrf
    @method('PUT')
<div class="form-group mb-3">
    <label for="cname" class="form-label">Name of Category</label>
    <input type="text" class="form-control" id="cname" name="name" 
           placeholder="Enter Category Name" value="{{ $data->category_name }}">
    <small class="form-text text-muted">Please write down Category Name here.</small>
</div>

<div class="mt-3 text-end">
    <button type="button" onClick="saveDataUpdate({{ $data->id }})" class="btn btn-primary">Submit</button>
</div>
    <button type="button" onClick="saveDataUpdate({{ $data->id }})" class="btn btn-primary">Submit</button>
{{-- </form> --}}