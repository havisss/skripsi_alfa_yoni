<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Repositories\Interfaces\StockMutationRepositoryInterface;
use App\Services\InventoryService;

class InventoryController extends Controller
{
    protected $productRepo;
    protected $mutationRepo;
    protected $inventoryService;

    public function __construct(
        ProductRepositoryInterface $productRepo,
        StockMutationRepositoryInterface $mutationRepo,
        InventoryService $inventoryService
    ) {
        $this->productRepo = $productRepo;
        $this->mutationRepo = $mutationRepo;
        $this->inventoryService = $inventoryService;
    }

    public function index()
    {
        $products = $this->productRepo->all();
        return view('inventory.index', compact('products'));
    }

    public function mutations()
    {
        $mutations = $this->mutationRepo->paginate(15);
        return view('inventory.mutations', compact('mutations'));
    }

    public function adjustStock(Request $request, $id)
    {
        $data = $request->validate([
            'type' => 'required|in:IN,OUT',
            'qty' => 'required|integer|min:1',
            'description' => 'nullable|string'
        ]);

        $result = $this->inventoryService->adjustStock($id, $data['type'], $data['qty'], $data['description']);

        if ($result['status'] === 'success') {
            return back()->with('success', $result['message']);
        } else {
            return back()->with('error', $result['message']);
        }
    }
}
