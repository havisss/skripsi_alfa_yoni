<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QcHistory extends Model
{
    protected $fillable = ['date', 'po_number', 'client', 'product_id', 'color', 'qty', 'status', 'description'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
