<?php
use App\Models\Product;
use App\Models\QcHistory;
use Illuminate\Support\Carbon;

$products = Product::all();
$clients = ['Boutique Hotel', 'Fine Dining Restaurant', 'Kevala Retail', 'Artisan Cafe', 'Private Collector'];
$colors = ['Natural Taupe', 'Muted Clay', 'Stone Grey', 'Terracotta', 'Sage Green', 'Off-white'];
$rejectReasons = ['Cracked surface during firing.', 'Uneven glaze application.', 'Warped shape.'];

$records = [];
// Generate 50 records
for ($i = 0; $i < 50; $i++) {
    // Only 5% chance of being rejected this time
    $isReject = rand(1, 100) <= 5; 
    $product = $products->random();
    
    $records[] = [
        'date' => Carbon::now()->subDays(rand(1, 60))->format('Y-m-d'),
        'po_number' => 'PO-2026-' . str_pad(rand(100, 999), 3, '0', STR_PAD_LEFT),
        'client' => $clients[array_rand($clients)],
        'product_id' => $product->id,
        'color' => $colors[array_rand($colors)],
        'qty' => $isReject ? rand(1, 15) : rand(100, 500),
        'status' => $isReject ? 'Reject' : 'OK',
        'description' => $isReject ? $rejectReasons[array_rand($rejectReasons)] : 'Passed all visual and structural QC tests. Export quality.',
        'created_at' => now(),
        'updated_at' => now(),
    ];
}

QcHistory::insert($records);

echo "Inserted 50 mostly passed records.\n";
