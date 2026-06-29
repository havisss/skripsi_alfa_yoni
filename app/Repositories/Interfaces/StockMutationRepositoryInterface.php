<?php

namespace App\Repositories\Interfaces;

interface StockMutationRepositoryInterface
{
    public function all();
    public function paginate($perPage = 10);
    public function create(array $data);
}
