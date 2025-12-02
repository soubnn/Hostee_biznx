<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesItems extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function product_detail()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
