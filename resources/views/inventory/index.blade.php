@extends('layouts.admin')

@section('title', 'Inventory Stock')

@section('content')
<div class="card">
    <div class="card-header bg-white fw-bold">Product Stock Inventory</div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="stockTable">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Product Name</th>
                        <th>Category</th>
                        <th>Current Stock</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                    <tr>
                        <td>{{ $product->code }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->category }}</td>
                        <td class="fw-bold">{{ $product->stock }}</td>
                        <td>
                            <button class="btn btn-sm btn-info text-white" data-bs-toggle="modal" data-bs-target="#adjustModal{{ $product->id }}">
                                <i class="bi bi-sliders"></i> Adjust
                            </button>

                            <!-- Adjust Modal -->
                            <div class="modal fade" id="adjustModal{{ $product->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <form action="{{ route('inventory.adjust', $product->id) }}" method="POST">
                                        @csrf
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Adjust Stock: {{ $product->name }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body text-start">
                                                <div class="mb-3">
                                                    <label>Type</label>
                                                    <select name="type" class="form-select" required>
                                                        <option value="IN">Stock IN (+)</option>
                                                        <option value="OUT">Stock OUT (-)</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Quantity</label>
                                                    <input type="number" name="qty" class="form-control" required min="1">
                                                </div>
                                                <div class="mb-3">
                                                    <label>Description (Reason)</label>
                                                    <input type="text" name="description" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Save changes</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#stockTable').DataTable();
    });
</script>
@endpush
