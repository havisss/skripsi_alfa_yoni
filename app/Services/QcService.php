<?php

namespace App\Services;

use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Repositories\Interfaces\QcHistoryRepositoryInterface;
use App\Repositories\Interfaces\StockMutationRepositoryInterface;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Carbon\Carbon;
use Exception;

class QcService
{
    protected $productRepo;
    protected $qcRepo;
    protected $mutationRepo;

    public function __construct(
        ProductRepositoryInterface $productRepo,
        QcHistoryRepositoryInterface $qcRepo,
        StockMutationRepositoryInterface $mutationRepo
    ) {
        $this->productRepo = $productRepo;
        $this->qcRepo = $qcRepo;
        $this->mutationRepo = $mutationRepo;
    }

    public function processManualQc(array $data)
    {
        DB::beginTransaction();
        try {
            // Check product
            $product = $this->productRepo->find($data['product_id']);
            if (!$product) {
                throw new Exception("Product not found");
            }

            // Create QC History
            $qc = $this->qcRepo->create($data);

            if ($data['status'] === 'OK') {
                $stockBefore = $product->stock;
                $this->productRepo->incrementStock($product->id, $data['qty']);
                $product->refresh();

                // Insert Stock Mutation
                $this->mutationRepo->create([
                    'product_id' => $product->id,
                    'type' => 'IN',
                    'qty' => $data['qty'],
                    'stock_before' => $stockBefore,
                    'stock_after' => $product->stock,
                    'description' => 'QC Passed: ' . $data['po_number'],
                ]);
            }

            DB::commit();
            return ['status' => 'success', 'message' => 'Manual QC saved successfully'];
        } catch (Exception $e) {
            DB::rollBack();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function processExcelUpload($filePath)
    {
        $spreadsheet = IOFactory::load($filePath);
        $worksheet = $spreadsheet->getActiveSheet();
        $rows = $worksheet->toArray();

        $totalRows = 0;
        $passed = 0;
        $reject = 0;
        $failed = 0;
        $failedRowsData = [];

        // Skip header
        array_shift($rows);

        foreach ($rows as $index => $row) {
            if (empty(array_filter($row))) {
                continue; // skip empty rows
            }
            $totalRows++;

            // Excel Format: Date, No PO, Client, Product Code, Product Name, Color, Qty, QC Result, Description
            $dateVal = $row[0];
            $poNumber = $row[1];
            $client = $row[2];
            $productCode = $row[3];
            $color = $row[5];
            $qty = (int)$row[6];
            $qcResult = strtoupper($row[7]);
            $description = $row[8];

            try {
                // Parse date (might be string or Excel numeric)
                $date = is_numeric($dateVal) 
                    ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($dateVal)->format('Y-m-d')
                    : Carbon::parse(str_replace('/', '-', $dateVal))->format('Y-m-d');

                DB::beginTransaction();

                $product = $this->productRepo->findByCode($productCode);
                if (!$product) {
                    throw new Exception("Product code $productCode not found");
                }

                $qcData = [
                    'date' => $date,
                    'po_number' => $poNumber,
                    'client' => $client,
                    'product_id' => $product->id,
                    'color' => $color,
                    'qty' => $qty,
                    'status' => $qcResult,
                    'description' => $description,
                ];

                $this->qcRepo->create($qcData);

                if ($qcResult === 'OK') {
                    $stockBefore = $product->stock;
                    $this->productRepo->incrementStock($product->id, $qty);
                    $product->refresh();

                    $this->mutationRepo->create([
                        'product_id' => $product->id,
                        'type' => 'IN',
                        'qty' => $qty,
                        'stock_before' => $stockBefore,
                        'stock_after' => $product->stock,
                        'description' => 'Auto QC Upload: ' . $poNumber,
                    ]);
                    $passed++;
                } else if ($qcResult === 'REJECT') {
                    $reject++;
                } else {
                    throw new Exception("Invalid status $qcResult");
                }

                DB::commit();
            } catch (Exception $e) {
                DB::rollBack();
                $failed++;
                $failedRowsData[] = "Row " . ($index + 2) . ": " . $e->getMessage();
            }
        }

        return [
            'total' => $totalRows,
            'passed' => $passed,
            'reject' => $reject,
            'failed' => $failed,
            'failed_data' => $failedRowsData
        ];
    }
}
