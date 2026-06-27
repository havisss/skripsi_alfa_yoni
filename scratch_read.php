<?php
require 'vendor/autoload.php';

echo "Reading DATA REJECT NFS 2026.xlsx...\n";
try {
    $spreadsheet1 = \PhpOffice\PhpSpreadsheet\IOFactory::load('DATA REJECT NFS 2026.xlsx');
    $data1 = $spreadsheet1->getActiveSheet()->toArray();
    print_r(array_slice($data1, 0, 5));
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

echo "\nReading FORM BAZAR 2026.xls...\n";
try {
    $spreadsheet2 = \PhpOffice\PhpSpreadsheet\IOFactory::load('FORM BAZAR 2026.xls');
    $data2 = $spreadsheet2->getActiveSheet()->toArray();
    print_r(array_slice($data2, 5, 15));
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
