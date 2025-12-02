<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consignment extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function customer_detail(){
        return $this->belongsTo(Customer::class, 'customer_name','id');
    }
}
