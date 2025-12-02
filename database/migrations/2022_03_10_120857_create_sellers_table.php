<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSellersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sellers', function (Blueprint $table) {
            $table->id();
            $table->String('seller_name');
            $table->String('seller_city')->nullable();
            $table->String('seller_area')->nullable();
            $table->String('seller_district')->nullable();
            $table->String('seller_state')->nullable();
            $table->String('seller_pincode')->nullable();
            $table->String('seller_phone')->nullable();
            $table->String('seller_mobile')->nullable();
            $table->String('seller_email')->nullable();
            $table->String('seller_state_code')->nullable();
            $table->String('seller_status')->default('active');
            $table->String('seller_opening_balance')->nullable();
            $table->String('seller_bank_name')->nullable();
            $table->String('seller_bank_acc_no')->nullable();
            $table->String('seller_bank_ifsc')->nullable();
            $table->String('seller_bank_branch')->nullable();
            $table->String('seller_gst')->nullable();
            $table->String('seller_pan')->nullable();
            $table->String('seller_tin')->nullable();
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
        Schema::dropIfExists('sellers');
    }
}
