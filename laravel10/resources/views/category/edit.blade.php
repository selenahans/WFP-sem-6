@extends('layouts.adminlte4')

@section('title', 'EDIT CATEGORY')

@section('content')
    <div class="container mt-4">
        <div class="card shadow border-0">
            <div class="card-header bg-warning py-3">
                <h5 class="mb-0 fw-bold text-dark">Edit Category: #{{ $category->id }}</h5>
            </div>
            <div class="card-body p-4">
                
                <form method="POST" action="{{ route('category.update', $category->id) }}">
                    @csrf
                    
                    @method('PUT')

                    <div class="form-group mb-4">
                        <label for="category_name" class="fw-bold">Category Name</label>
                        
                        <input type="text" class="form-control" id="category_name" name="categoryName" 
                               placeholder="Enter Category Name" value="{{ $category->category_name }}" required>
                        
                        <small class="form-text text-muted">Please write down Category Name here.</small>
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('category.index') }}" class="btn btn-secondary me-2">Cancel</a>
                        <button type="submit" class="btn btn-warning text-dark fw-bold">Update Category</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection