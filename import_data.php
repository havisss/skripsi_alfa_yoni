<?php

use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Product;
use App\Models\QcHistory;
use App\Models\StockMutation;
use PhpOffice\PhpSpreadsheet\IOFactory;

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Helper to format date
function parseDate($dateStr) {
    try {
        // e.g. 6/2/2026 -> m/d/Y or d/m/Y? Typically if day > 12 it's easy, let's try Carbon parse.
        // Assuming d/m/Y or m/d/Y. 
        if (is_numeric($dateStr)) {
            return \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($dateStr)->format('Y-m-d');
        }
        return Carbon::parse(str_replace('/', '-', $dateStr))->format('Y-m-d');
    } catch (\Exception $e) {
        return now()->format('Y-m-d');
    }
}

// Helper to extract number
function extractNumber($str) {
    preg_match('/\d+/', $str, $matches);
    return isset($matches[0]) ? (int)$matches[0] : 0;
}

// Helper to get or create product
function getOrCreateProduct($name, $unit = null) {
    if (empty(trim($name))) return null;
    
    // Check if exists
    $product = Product::where('name', $name)->first();
    if (!$product) {
        $code = 'PRD-' . strtoupper(Str::slug(substr($name, 0, 10))) . '-' . rand(1000, 9999);
        $product = Product::create([
            'code' => $code,
            'name' => $name,
            'unit' => $unit,
            'stock' => 0
        ]);
        echo "Created new product: $name ($code)\n";
    }
    return $product;
}

echo "--- IMPORTING DATA REJECT ---\n";
try {
    $spreadsheet = IOFactory::load('DATA REJECT NFS 2026.xlsx');
    $data = $spreadsheet->getActiveSheet()->toArray();
    
    // Starts at row 3 (index 3)
    for ($i = 3; $i < count($data); $i++) {
        $row = $data[$i];
        if (empty($row[0]) && empty($row[3])) continue; // Skip empty rows
        
        $dateStr = $row[0];
        $poNumber = $row[1];
        $client = $row[2];
        $itemName = $row[3];
        $color = $row[4];
        $qty = extractNumber((string)$row[5]);
        $desc = $row[6];
        
        $product = getOrCreateProduct($itemName);
        if ($product) {
            QcHistory::create([
                'date' => parseDate($dateStr),
                'po_number' => $poNumber,
                'client' => $client,
                'product_id' => $product->id,
                'color' => $color,
                'qty' => $qty,
                'status' => 'Reject',
                'description' => $desc,
            ]);
            echo "Imported QC Reject: {$product->name} (Qty: $qty)\n";
        }
    }
} catch (\Exception $e) {
    echo "Error processing QC Reject: " . $e->getMessage() . "\n";
}

echo "\n--- IMPORTING BAZAR MUTATION ---\n";
try {
    $spreadsheet = IOFactory::load('FORM BAZAR 2026.xls');
    $data = $spreadsheet->getActiveSheet()->toArray();
    
    // Extract date from index 1, col 1 ": 19/06/2026"
    $bazarDateStr = isset($data[1][1]) ? str_replace(': ', '', $data[1][1]) : now()->format('Y-m-d');
    $bazarDate = parseDate($bazarDateStr);
    
    // Starts at row 10 (index 5)
    for ($i = 5; $i < count($data); $i++) {
        $row = $data[$i];
        if (empty($row[1])) continue; // No NAMA BARANG
        
        $itemName = $row[1];
        $unit = $row[3];
        $qtyStr = $row[4]; // e.g. "42 pcs"
        $qty = extractNumber($qtyStr);
        $desc = $row[5] ?? 'BAZAR';
        
        $product = getOrCreateProduct($itemName, $unit);
        if ($product && $qty > 0) {
            $stockBefore = $product->stock;
            $stockAfter = $stockBefore - $qty;
            
            StockMutation::create([
                'product_id' => $product->id,
                'type' => 'OUT',
                'qty' => $qty,
                'stock_before' => $stockBefore,
                'stock_after' => $stockAfter,
                'description' => $desc . ' (' . $bazarDate . ')',
            ]);
            
            // Update product stock
            $product->update(['stock' => $stockAfter]);
            
            echo "Imported Bazar Mutation OUT: {$product->name} (Qty: $qty)\n";
        }
    }
} catch (\Exception $e) {
    echo "Error processing Bazar: " . $e->getMessage() . "\n";
}

echo "\nImport Finished.\n";
