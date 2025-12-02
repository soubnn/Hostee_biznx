<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseReturn extends Model
{
    use HasFactory;
    public function purchase_details(){
        return $this->belongsTo(Purchase::class,'purchase_id', 'id');
    }
}
