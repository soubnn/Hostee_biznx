<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDirectSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('direct_sales', function (Blueprint $table) {
            $table->id();
            $table->string('sales_date')->nullable();
            $table->string('invoice_number')->nullable();
            $table->string('customer_name')->nullable();
            $table->string('customer_place')->nullable();
            $table->string('customer_phone')->nullable();
            $table->string('pay_method')->nullable();
            $table->integer('sales_staff')->nullable();
            $table->string('discount')->nullable();
            $table->string('grand_total')->nullable();
            $table->string('is_gst')->nullable();
            $table->string('gst_number')->nullable();
            $table->string('print_status')->default('not_printed');
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
        Schema::dropIfExists('direct_sales');
    }
}
