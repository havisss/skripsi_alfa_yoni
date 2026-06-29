<?php
use App\Models\Product;
use App\Models\QcHistory;
use Illuminate\Support\Carbon;

// Ensure we have some products
if (Product::count() === 0) {
    Product::create([
        'code' => 'KVL-P-01',
        'name' => 'Rustic Dinner Plate',
        'category' => 'Plate',
        'unit' => 'pcs',
        'stock' => 500
    ]);
    
    Product::create([
        'code' => 'KVL-B-01',
        'name' => 'Earthy Soup Bowl',
        'category' => 'Bowl',
        'unit' => 'pcs',
        'stock' => 300
    ]);
}

$products = Product::all();
$clients = ['Boutique Hotel', 'Fine Dining Restaurant', 'Kevala Retail', 'Artisan Cafe', 'Private Collector'];
$colors = ['Natural Taupe', 'Muted Clay', 'Stone Grey', 'Terracotta', 'Sage Green', 'Off-white'];
$rejectReasons = ['Cracked surface during firing.', 'Uneven glaze application.', 'Warped shape.', 'Color inconsistency.', 'Chipped edge.', 'Pinholes in glaze.'];

$records = [];
// Generate 35 records
for ($i = 0; $i < 35; $i++) {
    $isReject = rand(1, 100) <= 20; // 20% chance of being rejected
    $product = $products->random();
    
    $records[] = [
        'date' => Carbon::now()->subDays(rand(1, 45))->format('Y-m-d'),
        'po_number' => 'PO-2026-' . str_pad(rand(10, 99), 3, '0', STR_PAD_LEFT),
        'client' => $clients[array_rand($clients)],
        'product_id' => $product->id,
        'color' => $colors[array_rand($colors)],
        'qty' => $isReject ? rand(1, 15) : rand(50, 300),
        'status' => $isReject ? 'Reject' : 'OK',
        'description' => $isReject ? $rejectReasons[array_rand($rejectReasons)] : 'Passed all visual and structural QC tests.',
        'created_at' => now(),
        'updated_at' => now(),
    ];
}

QcHistory::insert($records);

echo "Inserted 35 more realistic mock records.\n";
