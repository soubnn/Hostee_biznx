<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProformaInvoiceItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proforma_invoice_items', function (Blueprint $table) {
            $table->id();
            $table->String('Proforma_id');
            $table->String('product_name')->nullable();
            $table->String('warrenty')->nullable();
            $table->String('unit_price')->nullable();
            $table->String('qty')->nullable();
            $table->String('product_tax')->nullable();
            $table->String('total')->nullable();
            $table->String('status')->default('active');
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
        Schema::dropIfExists('proforma_invoice_items');
    }
}
