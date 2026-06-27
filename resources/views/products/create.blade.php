@extends('layouts.admin')

@section('title', 'Add Product')

@section('content')
<div class="card">
    <div class="card-header bg-white fw-bold">Add New Product</div>
    <div class="card-body">
        <form action="{{ route('products.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label>Code</label>
                <input type="text" name="code" class="form-control" required value="{{ old('code') }}">
            </div>
            <div class="mb-3">
                <label>Name</label>
                <input type="text" name="name" class="form-control" required value="{{ old('name') }}">
            </div>
            <div class="mb-3">
                <label>Category</label>
                <input type="text" name="category" class="form-control" value="{{ old('category') }}">
            </div>
            <div class="mb-3">
                <label>Unit</label>
                <input type="text" name="unit" class="form-control" value="{{ old('unit') }}">
            </div>
            <button class="btn btn-primary">Save Product</button>
            <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection
