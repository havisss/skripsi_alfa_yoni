@extends('layouts.admin')

@section('title', 'Reports')

@section('content')
<div class="row">
    <!-- QC Report -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header bg-white fw-bold">QC Report</div>
            <div class="card-body">
                <form action="{{ route('reports.generateQc') }}" method="POST">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label>Start Date</label>
                            <input type="date" name="start_date" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label>End Date</label>
                            <input type="date" name="end_date" class="form-control">
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" name="export" value="pdf" class="btn btn-danger"><i class="bi bi-file-earmark-pdf"></i> Export PDF</button>
                        <button type="submit" name="export" value="excel" class="btn btn-success"><i class="bi bi-file-earmark-excel"></i> Export Excel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Inventory Report -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header bg-white fw-bold">Inventory Report</div>
            <div class="card-body">
                <form action="{{ route('reports.generateInventory') }}" method="POST">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label>Start Date</label>
                            <input type="date" name="start_date" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label>End Date</label>
                            <input type="date" name="end_date" class="form-control">
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" name="export" value="pdf" class="btn btn-danger"><i class="bi bi-file-earmark-pdf"></i> Export PDF</button>
                        <button type="submit" name="export" value="excel" class="btn btn-success"><i class="bi bi-file-earmark-excel"></i> Export Excel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
