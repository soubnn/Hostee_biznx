<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProformaInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proforma_invoices', function (Blueprint $table) {
            $table->id();
            $table->String('invoice_number')->nullable();
            $table->String('invoice_date')->nullable();
            $table->String('customer_name')->nullable();
            $table->String('customer_phone')->nullable();
            $table->String('gst_available')->nullable();
            $table->String('gst_number')->nullable();
            $table->String('grand_total')->nullable();
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
        Schema::dropIfExists('proforma_invoices');
    }
}
