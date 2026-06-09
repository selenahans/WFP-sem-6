@extends('layouts.adminlte4')
@section('title', 'EDIT SERVICE')
@section('content')
<div class="container mt-4">
    <div class="card shadow border-0">
        <div class="card-header bg-warning py-3">
            <h5 class="mb-0 fw-bold text-dark">Form Edit Service: #{{ $service->id }}</h5>
        </div>
        <div class="card-body p-4">
            <form method="POST" action="{{ route('services.update', $service->id) }}">
                @csrf
                @method('PUT') <div class="form-group mb-3">
                    <label for="name" class="fw-bold">Service Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $service->name }}" placeholder="Enter Service Name" required>
                    <small class="form-text text-muted">Please write down the service name here.</small>
                </div>

                <div class="form-group mb-3">
                    <label for="description" class="fw-bold">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter Service Description" required>{{ $service->description }}</textarea>
                </div>

                <div class="row">
                    <div class="col-md-6 form-group mb-3">
                        <label for="available_from" class="fw-bold">Available From</label>
                        <input type="time" class="form-control" id="available_from" name="available_from" value="{{ \Carbon\Carbon::parse($service->available_from)->format('H:i') }}" required>
                    </div>

                    <div class="col-md-6 form-group mb-3">
                        <label for="available_to" class="fw-bold">Available To</label>
                        <input type="time" class="form-control" id="available_to" name="available_to" value="{{ \Carbon\Carbon::parse($service->available_to)->format('H:i') }}" required>
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label for="category_id" class="fw-bold">Category</label>
                    <select class="form-control form-select" id="category_id" name="category_id" required>
                        <option value="" disabled>-- Select Category --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ $service->category_id == $category->id ? 'selected' : '' }}>
                                {{ $category->category_name }}
                            </option>
                        @endforeach
                    </select>
                    <small class="form-text text-muted">Select the appropriate category for this service.</small>
                </div>

                <div class="form-group mb-4">
                    <label for="price" class="fw-bold">Price (Rp)</label>
                    <input type="number" step="0.01" class="form-control" id="price" name="price" value="{{ $service->price }}" placeholder="Enter Price (e.g. 50000)" required>
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('service.index') }}" class="btn btn-secondary me-2">Cancel</a>
                    <button type="submit" class="btn btn-warning text-dark fw-bold">Update Service</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection