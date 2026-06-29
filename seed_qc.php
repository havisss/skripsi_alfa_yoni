<?php
use App\Models\Product;
use App\Models\QcHistory;

// Ensure we have some products
if (Product::count() === 0) {
    $p1 = Product::create([
        'code' => 'KVL-P-01',
        'name' => 'Rustic Dinner Plate',
        'category' => 'Plate',
        'unit' => 'pcs',
        'stock' => 500
    ]);
    
    $p2 = Product::create([
        'code' => 'KVL-B-01',
        'name' => 'Earthy Soup Bowl',
        'category' => 'Bowl',
        'unit' => 'pcs',
        'stock' => 300
    ]);
} else {
    $p1 = Product::first();
    $p2 = Product::skip(1)->first() ?? $p1;
}

// Create some QC records
QcHistory::create([
    'date' => now()->subDays(2)->format('Y-m-d'),
    'po_number' => 'PO-2026-001',
    'client' => 'Boutique Hotel',
    'product_id' => $p1->id,
    'color' => 'Natural Taupe',
    'qty' => 150,
    'status' => 'OK',
    'description' => 'Passed visual and strength tests.'
]);

QcHistory::create([
    'date' => now()->subDays(2)->format('Y-m-d'),
    'po_number' => 'PO-2026-001',
    'client' => 'Boutique Hotel',
    'product_id' => $p1->id,
    'color' => 'Natural Taupe',
    'qty' => 5,
    'status' => 'Reject',
    'description' => 'Cracked surface during firing.'
]);

QcHistory::create([
    'date' => now()->subDays(1)->format('Y-m-d'),
    'po_number' => 'PO-2026-002',
    'client' => 'Fine Dining Restaurant',
    'product_id' => $p2->id,
    'color' => 'Muted Clay',
    'qty' => 200,
    'status' => 'OK',
    'description' => 'All passed.'
]);

QcHistory::create([
    'date' => now()->subDays(1)->format('Y-m-d'),
    'po_number' => 'PO-2026-002',
    'client' => 'Fine Dining Restaurant',
    'product_id' => $p2->id,
    'color' => 'Muted Clay',
    'qty' => 12,
    'status' => 'Reject',
    'description' => 'Uneven glaze application.'
]);

echo "Mock data seeded successfully.\n";
