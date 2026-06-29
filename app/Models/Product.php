<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['code', 'name', 'category', 'unit', 'stock'];

    public function qcHistories()
    {
        return $this->hasMany(QcHistory::class);
    }

    public function stockMutations()
    {
        return $this->hasMany(StockMutation::class);
    }
}
