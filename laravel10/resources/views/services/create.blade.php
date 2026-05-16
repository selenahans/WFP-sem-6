@extends('layouts.adminlte4')

@section('title', 'CREATE NEW SERVICE')

@section('content')
<div class="container mt-4">
    <div class="card shadow border-0">
        <div class="card-header bg-primary py-3">
            <h5 class="mb-0 fw-bold text-white">Form Input New Service</h5>
        </div>
        <div class="card-body p-4">
            {{-- Pastikan action route mengarah ke store milik service --}}
            <form method="POST" action="{{ route('service.store') }}">
                @csrf

                <div class="form-group mb-3">
                    <label for="name" class="fw-bold">Service Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter Service Name" required>
                    <small class="form-text text-muted">Please write down the service name here.</small>
                </div>

                <div class="form-group mb-3">
                    <label for="description" class="fw-bold">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter Service Description" required></textarea>
                </div>

                <div class="row">
                    <div class="col-md-6 form-group mb-3">
                        <label for="available_from" class="fw-bold">Available From</label>
                        <input type="time" class="form-control" id="available_from" name="available_from" required>
                    </div>

                    <div class="col-md-6 form-group mb-3">
                        <label for="available_to" class="fw-bold">Available To</label>
                        <input type="time" class="form-control" id="available_to" name="available_to" required>
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label for="category_id" class="fw-bold">Category</label>
                    <select class="form-control form-select" id="category_id" name="category_id" required>
                        <option value="" disabled selected>-- Select Category --</option>
                        {{-- Melakukan perulangan data $categories yang di-parsing dari controller --}}
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                        @endforeach
                    </select>
                    <small class="form-text text-muted">Select the appropriate category for this service.</small>
                </div>

                <div class="form-group mb-4">
                    <label for="price" class="fw-bold">Price (Rp)</label>
                    <input type="number" step="0.01" class="form-control" id="price" name="price" placeholder="Enter Price (e.g. 50000)" required>
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('service.index') }}" class="btn btn-secondary me-2">Cancel</a>
                    <button type="submit" class="btn btn-primary">Submit New Service</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection