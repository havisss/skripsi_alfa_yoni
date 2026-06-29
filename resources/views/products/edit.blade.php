@extends('layouts.admin')

@section('title', 'Edit Product')

@section('content')
<div class="card">
    <div class="card-header bg-white fw-bold">Edit Product: {{ $product->name }}</div>
    <div class="card-body">
        <form action="{{ route('products.update', $product->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label>Code</label>
                <input type="text" name="code" class="form-control" required value="{{ old('code', $product->code) }}">
            </div>
            <div class="mb-3">
                <label>Name</label>
                <input type="text" name="name" class="form-control" required value="{{ old('name', $product->name) }}">
            </div>
            <div class="mb-3">
                <label>Category</label>
                <input type="text" name="category" class="form-control" value="{{ old('category', $product->category) }}">
            </div>
            <div class="mb-3">
                <label>Unit</label>
                <input type="text" name="unit" class="form-control" value="{{ old('unit', $product->unit) }}">
            </div>
            <button class="btn btn-primary">Update Product</button>
            <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection
