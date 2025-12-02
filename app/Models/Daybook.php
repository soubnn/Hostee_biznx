<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Daybook extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function sales_detail(){
        return $this->belongsTo(DirectSales::class, 'job','invoice_number');
    }
    public function staffs_detail(){
        return $this->belongsTo(staffs::class, 'staff','id');
    }
    public function investor_detail(){
        return $this->belongsTo(Investor::class, 'staff','id');
    }
    public function bank_detail(){
        return $this->belongsTo(Bank::class, 'staff','id');
    }
    public function sellers_detail(){
        return $this->belongsTo(Seller::class, 'job','id');
    }
    public function expenses_detail(){
        return $this->belongsTo(Expense::class, 'expense_id','id');
    }
    public function incomes_detail(){
        return $this->belongsTo(Income::class, 'income_id','id');
    }
    public function purchase_return_detail(){
        return $this->belongsTo(PurchaseReturn::class, 'job','invoice_number');
    }

}
