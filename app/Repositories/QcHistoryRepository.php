<?php

namespace App\Repositories;

use App\Models\QcHistory;
use App\Repositories\Interfaces\QcHistoryRepositoryInterface;
use Carbon\Carbon;

class QcHistoryRepository implements QcHistoryRepositoryInterface
{
    public function all()
    {
        return QcHistory::with('product')->orderBy('created_at', 'desc')->get();
    }

    public function find($id)
    {
        return QcHistory::findOrFail($id);
    }

    public function create(array $data)
    {
        return QcHistory::create($data);
    }

    public function paginate($perPage = 10)
    {
        return QcHistory::with('product')->orderBy('created_at', 'desc')->paginate($perPage);
    }

    public function getTodayCount()
    {
        return QcHistory::whereDate('date', Carbon::today())->count();
    }

    public function getPassedCount()
    {
        return QcHistory::where('status', 'OK')->count();
    }

    public function getRejectCount()
    {
        return QcHistory::where('status', 'Reject')->count();
    }
}
