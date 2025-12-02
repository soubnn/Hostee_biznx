<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_items', function (Blueprint $table) {
            $table->id();
            $table->string('sales_id');
            $table->string('product_id');
            $table->string('product_name')->nullable();
            $table->string('unit_price')->nullable();
            $table->string('product_quantity')->nullable();
            $table->string('gst_percent')->nullable();
            $table->string('sales_price')->nullable();
            $table->string('sales_date')->nullable();
            $table->string('serial_number')->nullable();
            $table->string('warranty')->nullable();
            $table->string('gst_available')->nullable();
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
        Schema::dropIfExists('sales_items');
    }
}
