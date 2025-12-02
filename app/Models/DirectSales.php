<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DirectSales extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function customer_detail(){
        return $this->belongsTo(Customer::class, 'customer_id','id');
    }

    public function staff_detail()
    {
        return $this->belongsTo(staffs::class, 'sales_staff', 'id');
    }
    public function sales_items()
    {
        return $this->hasMany(SalesItems::class, 'sales_id');
    }

    public function consolidate_bill()
    {
        return $this->hasOne(Consoulidate::class, 'sales_id');
    }
}
