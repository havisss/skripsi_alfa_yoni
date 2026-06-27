@extends('layouts.admin')

@section('title', 'Upload Auto QC')

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-white fw-bold">Upload Excel File</div>
            <div class="card-body">
                <form id="uploadForm" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Select Excel File (.xlsx, .csv)</label>
                        <input type="file" name="file" id="file" class="form-control" required accept=".xlsx,.xls,.csv">
                    </div>
                    <button type="submit" class="btn btn-primary" id="btnUpload">
                        <i class="bi bi-upload"></i> Process File
                    </button>
                    <div class="spinner-border spinner-border-sm text-primary d-none ms-2" id="loading" role="status"></div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 d-none" id="resultCard">
        <div class="card">
            <div class="card-header bg-white fw-bold">Result Summary</div>
            <div class="card-body">
                <ul class="list-group mb-3">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Total Rows Processed
                        <span class="badge bg-primary rounded-pill" id="res-total">0</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Passed (OK)
                        <span class="badge bg-success rounded-pill" id="res-passed">0</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Reject
                        <span class="badge bg-danger rounded-pill" id="res-reject">0</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Failed Rows (Errors)
                        <span class="badge bg-warning text-dark rounded-pill" id="res-failed">0</span>
                    </li>
                </ul>
                <div id="failed-data-container" class="d-none">
                    <h6 class="text-danger fw-bold">Failed Details:</h6>
                    <ul class="text-danger small" id="failed-data-list"></ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#uploadForm').on('submit', function(e) {
        e.preventDefault();
        
        let formData = new FormData(this);
        let btn = $('#btnUpload');
        let loading = $('#loading');
        
        btn.prop('disabled', true);
        loading.removeClass('d-none');
        $('#resultCard').addClass('d-none');
        
        $.ajax({
            url: '{{ route("qc.processUpload") }}',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(res) {
                $('#res-total').text(res.total);
                $('#res-passed').text(res.passed);
                $('#res-reject').text(res.reject);
                $('#res-failed').text(res.failed);
                
                if (res.failed > 0) {
                    $('#failed-data-container').removeClass('d-none');
                    let list = '';
                    res.failed_data.forEach(function(item) {
                        list += '<li>'+item+'</li>';
                    });
                    $('#failed-data-list').html(list);
                } else {
                    $('#failed-data-container').addClass('d-none');
                }
                
                $('#resultCard').removeClass('d-none');
                Swal.fire({ icon: 'success', title: 'Upload Complete', text: 'File has been processed.' });
                $('#uploadForm')[0].reset();
            },
            error: function(err) {
                let msg = 'An error occurred during upload.';
                if (err.responseJSON && err.responseJSON.message) {
                    msg = err.responseJSON.message;
                }
                Swal.fire({ icon: 'error', title: 'Error', text: msg });
            },
            complete: function() {
                btn.prop('disabled', false);
                loading.addClass('d-none');
            }
        });
    });
});
</script>
@endpush
