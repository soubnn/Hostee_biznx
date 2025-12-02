<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->integer('category_id');
            $table->string('product_code');
            $table->string('product_name');
            $table->string('hsn_code')->nullable();
            $table->string('product_price')->nullable();
            $table->string('product_selling_price')->nullable();
            $table->string('product_mrp')->nullable();
            $table->string('product_description')->nullable();
            $table->string('product_unit_details')->nullable();
            $table->string('product_schedule')->nullable();
            $table->string('product_tax_percent')->nullable();
            $table->string('product_cgst')->nullable();
            $table->string('product_sgst')->nullable();
            $table->string('product_igst')->nullable();
            $table->integer('product_max_stock')->default(0);
            $table->string('product_batch')->nullable();
            $table->string('product_expiry_date')->nullable();
            $table->string('product_supplier')->nullable();
            $table->string('product_company')->nullable();
            $table->string('product_brand')->nullable();
            $table->string('product_image')->nullable();
            $table->string('product_status')->default('active');
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
        Schema::dropIfExists('products');
    }
}
