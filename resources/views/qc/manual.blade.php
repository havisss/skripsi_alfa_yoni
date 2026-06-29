@extends('layouts.admin')

@section('title', 'Manual QC Input')

@section('content')
<div class="card">
    <div class="card-header bg-white fw-bold">Manual QC Form</div>
    <div class="card-body">
        <form action="{{ route('qc.storeManual') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Date</label>
                    <input type="date" name="date" class="form-control" required value="{{ old('date', date('Y-m-d')) }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label>Product</label>
                    <select name="product_id" class="form-select" required>
                        <option value="">Select Product...</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                {{ $product->code }} - {{ $product->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label>PO Number</label>
                    <input type="text" name="po_number" class="form-control" value="{{ old('po_number') }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label>Client</label>
                    <input type="text" name="client" class="form-control" value="{{ old('client') }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label>Color</label>
                    <input type="text" name="color" class="form-control" value="{{ old('color') }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label>Quantity</label>
                    <input type="number" name="qty" class="form-control" required min="1" value="{{ old('qty', 1) }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label>QC Status</label>
                    <select name="status" class="form-select" required>
                        <option value="OK" {{ old('status') == 'OK' ? 'selected' : '' }}>OK (Passed)</option>
                        <option value="Reject" {{ old('status') == 'Reject' ? 'selected' : '' }}>Reject</option>
                    </select>
                </div>
                <div class="col-md-12 mb-3">
                    <label>Description</label>
                    <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                </div>
            </div>
            <button class="btn btn-primary"><i class="bi bi-save"></i> Save QC Data</button>
        </form>
    </div>
</div>
@endsection
