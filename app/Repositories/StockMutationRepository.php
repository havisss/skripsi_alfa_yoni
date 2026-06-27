<?php

namespace App\Repositories;

use App\Models\StockMutation;
use App\Repositories\Interfaces\StockMutationRepositoryInterface;

class StockMutationRepository implements StockMutationRepositoryInterface
{
    public function all()
    {
        return StockMutation::with('product')->orderBy('created_at', 'desc')->get();
    }

    public function paginate($perPage = 10)
    {
        return StockMutation::with('product')->orderBy('created_at', 'desc')->paginate($perPage);
    }

    public function create(array $data)
    {
        return StockMutation::create($data);
    }
}
