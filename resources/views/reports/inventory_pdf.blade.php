<!DOCTYPE html>
<html>
<head>
    <title>Inventory Report</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 5px; text-align: left; }
        th { background-color: #f2f2f2; }
        .text-center { text-align: center; }
    </style>
</head>
<body>
    <h2 class="text-center">Stock Mutation Report</h2>
    @if($start && $end)
        <p class="text-center">Period: {{ $start->format('d/m/Y') }} - {{ $end->format('d/m/Y') }}</p>
    @else
        <p class="text-center">All Data</p>
    @endif

    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Product</th>
                <th>Type</th>
                <th>Qty</th>
                <th>Beg. Stock</th>
                <th>End Stock</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $row)
            <tr>
                <td>{{ $row->created_at->format('Y-m-d H:i') }}</td>
                <td>{{ $row->product ? $row->product->name : '-' }}</td>
                <td>{{ $row->type }}</td>
                <td>{{ $row->qty }}</td>
                <td>{{ $row->stock_before }}</td>
                <td>{{ $row->stock_after }}</td>
                <td>{{ $row->description }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
