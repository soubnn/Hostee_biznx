<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->string('ref_no')->nullable();
            $table->string('transaction_type')->nullable();
            $table->string('invoice_no')->unique();
            $table->string('invoice_date')->nullable();
            $table->string('delivery_date')->nullable();
            $table->string('seller_details')->nullable();
            $table->string('discount')->nullable();
            $table->string('grand_total')->nullable();
            $table->string('purchase_bill')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchases');
    }
}
