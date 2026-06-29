<?php

namespace App\Repositories\Interfaces;

interface QcHistoryRepositoryInterface
{
    public function all();
    public function find($id);
    public function create(array $data);
    public function paginate($perPage = 10);
    public function getTodayCount();
    public function getPassedCount();
    public function getRejectCount();
}
