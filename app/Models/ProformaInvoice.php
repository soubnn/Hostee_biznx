<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProformaInvoice extends Model
{
    use HasFactory;

    protected $casts = [
        'customer_name' => 'integer',
    ];

    public function customer_detail(){
        return $this->belongsTo(Customer::class, 'customer_name', 'id');
    }
}
