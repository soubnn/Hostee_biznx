<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function purchases()
    {
        return $this->hasMany(Purchase::class, 'seller_details');
    }

    public function payments()
    {
        return $this->hasMany(Daybook::class, 'job')->where('expense_id', 'FOR_SUPPLIER');
    }
}
