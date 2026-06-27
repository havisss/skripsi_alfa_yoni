@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h6 class="card-title"><i class="bi bi-box"></i> Total Products</h6>
                <h3 id="stat-products">0</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <h6 class="card-title"><i class="bi bi-layers"></i> Current Inventory</h6>
                <h3 id="stat-stock">0</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <h6 class="card-title"><i class="bi bi-check-circle"></i> Passed (OK)</h6>
                <h3 id="stat-passed">0</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-danger text-white">
            <div class="card-body">
                <h6 class="card-title"><i class="bi bi-x-circle"></i> Reject</h6>
                <h3 id="stat-reject">0</h3>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-header bg-white fw-bold">QC Statistics (Overall)</div>
            <div class="card-body">
                <canvas id="qcChart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-header bg-white fw-bold">Latest QC Activity</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Product</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody id="latest-qc">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    let qcChart = null;

    function loadDashboardData() {
        $.ajax({
            url: '{{ route("dashboard.stats") }}',
            type: 'GET',
            success: function(res) {
                $('#stat-products').text(res.total_products);
                $('#stat-stock').text(res.total_stock);
                $('#stat-passed').text(res.total_passed);
                $('#stat-reject').text(res.total_reject);

                // Update Chart
                if (qcChart) {
                    qcChart.data.datasets[0].data = res.qc_chart_data.data;
                    qcChart.update();
                } else {
                    const ctx = document.getElementById('qcChart').getContext('2d');
                    qcChart = new Chart(ctx, {
                        type: 'doughnut',
                        data: {
                            labels: res.qc_chart_data.labels,
                            datasets: [{
                                data: res.qc_chart_data.data,
                                backgroundColor: ['#7f8a70', '#bc8a7a'],
                                borderColor: ['#f4f2eb', '#f4f2eb'],
                                borderWidth: 2
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false
                        }
                    });
                }

                // Update Latest QC Table
                let qcHtml = '';
                if (res.latest_qc.length > 0) {
                    res.latest_qc.forEach(function(item) {
                        let badge = item.status === 'OK' ? 'bg-success' : 'bg-danger';
                        qcHtml += `<tr>
                            <td>${item.date}</td>
                            <td>${item.product ? item.product.name : '-'}</td>
                            <td><span class="badge ${badge}">${item.status}</span></td>
                        </tr>`;
                    });
                } else {
                    qcHtml = '<tr><td colspan="3" class="text-center">No data</td></tr>';
                }
                $('#latest-qc').html(qcHtml);
            }
        });
    }

    loadDashboardData();
    // Auto update every 30 seconds
    setInterval(loadDashboardData, 30000);
});
</script>
@endpush
