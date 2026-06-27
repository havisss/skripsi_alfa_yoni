@extends('layouts.admin')

@section('title', 'QC History')

@section('content')
<div class="card">
    <div class="card-header bg-white fw-bold">QC History Log</div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="qcTable">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>PO Number</th>
                        <th>Client</th>
                        <th>Product</th>
                        <th>Color</th>
                        <th>Qty</th>
                        <th>Status</th>
                        <th>Desc</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($histories as $history)
                    <tr>
                        <td>{{ $history->date }}</td>
                        <td>{{ $history->po_number }}</td>
                        <td>{{ $history->client }}</td>
                        <td>{{ $history->product ? $history->product->name : '-' }}</td>
                        <td>{{ $history->color }}</td>
                        <td>{{ $history->qty }}</td>
                        <td>
                            <span class="badge {{ $history->status == 'OK' ? 'bg-success' : 'bg-danger' }}">
                                {{ $history->status }}
                            </span>
                        </td>
                        <td>{{ $history->description }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $histories->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection
