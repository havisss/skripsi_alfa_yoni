<?php

namespace App\Services;

use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Repositories\Interfaces\StockMutationRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Exception;

class InventoryService
{
    protected $productRepo;
    protected $mutationRepo;

    public function __construct(
        ProductRepositoryInterface $productRepo,
        StockMutationRepositoryInterface $mutationRepo
    ) {
        $this->productRepo = $productRepo;
        $this->mutationRepo = $mutationRepo;
    }

    public function adjustStock($productId, $type, $qty, $description)
    {
        DB::beginTransaction();
        try {
            $product = $this->productRepo->find($productId);
            $stockBefore = $product->stock;

            if ($type === 'IN') {
                $this->productRepo->incrementStock($productId, $qty);
            } else if ($type === 'OUT') {
                if ($product->stock < $qty) {
                    throw new Exception("Insufficient stock");
                }
                $this->productRepo->decrementStock($productId, $qty);
            }

            $product->refresh();

            $this->mutationRepo->create([
                'product_id' => $product->id,
                'type' => $type === 'IN' || $type === 'OUT' ? $type : 'ADJUSTMENT', // Assuming ADJUSTMENT handles both somehow, we'll keep IN/OUT
                'qty' => $qty,
                'stock_before' => $stockBefore,
                'stock_after' => $product->stock,
                'description' => $description,
            ]);

            DB::commit();
            return ['status' => 'success', 'message' => 'Stock adjusted successfully'];
        } catch (Exception $e) {
            DB::rollBack();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }
}
