<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function category_details()
    {
        return $this->belongsTo(product_categories::class, 'category_id', 'id');
    }
    public function salesItems()
    {
        return $this->hasMany(SalesItems::class, 'product_id');
    }
}
