<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Interfaces\ProductRepositoryInterface;

class ProductController extends Controller
{
    protected $productRepo;

    public function __construct(ProductRepositoryInterface $productRepo)
    {
        $this->productRepo = $productRepo;
    }

    public function index()
    {
        $products = $this->productRepo->all();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'code' => 'required|unique:products,code',
            'name' => 'required',
            'category' => 'nullable',
            'unit' => 'nullable',
        ]);

        $this->productRepo->create($data);
        return redirect()->route('products.index')->with('success', 'Product created successfully');
    }

    public function edit($id)
    {
        $product = $this->productRepo->find($id);
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'code' => 'required|unique:products,code,'.$id,
            'name' => 'required',
            'category' => 'nullable',
            'unit' => 'nullable',
        ]);

        $this->productRepo->update($id, $data);
        return redirect()->route('products.index')->with('success', 'Product updated successfully');
    }

    public function destroy($id)
    {
        $this->productRepo->delete($id);
        return redirect()->route('products.index')->with('success', 'Product deleted successfully');
    }
}
