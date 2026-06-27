@extends('layouts.admin')

@section('title', 'Stock Mutations')

@section('content')
<div class="card">
    <div class="card-header bg-white fw-bold">Stock Mutation Log</div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Date & Time</th>
                        <th>Product</th>
                        <th>Type</th>
                        <th>Qty</th>
                        <th>Beg. Stock</th>
                        <th>End Stock</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($mutations as $mutation)
                    <tr>
                        <td>{{ $mutation->created_at->format('Y-m-d H:i') }}</td>
                        <td>{{ $mutation->product ? $mutation->product->name : '-' }}</td>
                        <td>
                            @if($mutation->type === 'IN')
                                <span class="badge bg-success">IN</span>
                            @elseif($mutation->type === 'OUT')
                                <span class="badge bg-danger">OUT</span>
                            @else
                                <span class="badge bg-warning text-dark">ADJUSTMENT</span>
                            @endif
                        </td>
                        <td>{{ $mutation->qty }}</td>
                        <td>{{ $mutation->stock_before }}</td>
                        <td>{{ $mutation->stock_after }}</td>
                        <td>{{ $mutation->description }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $mutations->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection
