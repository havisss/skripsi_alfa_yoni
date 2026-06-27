<?php

namespace App\Repositories\Interfaces;

interface ProductRepositoryInterface
{
    public function all();
    public function find($id);
    public function findByCode($code);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
    public function incrementStock($id, $qty);
    public function decrementStock($id, $qty);
}
