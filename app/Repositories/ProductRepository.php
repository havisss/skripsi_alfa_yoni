<?php

namespace App\Repositories;

use App\Models\Product;
use App\Repositories\Interfaces\ProductRepositoryInterface;

class ProductRepository implements ProductRepositoryInterface
{
    public function all()
    {
        return Product::all();
    }

    public function find($id)
    {
        return Product::findOrFail($id);
    }

    public function findByCode($code)
    {
        return Product::where('code', $code)->first();
    }

    public function create(array $data)
    {
        return Product::create($data);
    }

    public function update($id, array $data)
    {
        $product = $this->find($id);
        $product->update($data);
        return $product;
    }

    public function delete($id)
    {
        $product = $this->find($id);
        return $product->delete();
    }

    public function incrementStock($id, $qty)
    {
        $product = $this->find($id);
        $product->increment('stock', $qty);
        return $product;
    }

    public function decrementStock($id, $qty)
    {
        $product = $this->find($id);
        $product->decrement('stock', $qty);
        return $product;
    }
}
