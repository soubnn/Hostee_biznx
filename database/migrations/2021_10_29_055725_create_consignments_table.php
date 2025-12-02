<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsignmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consignments', function (Blueprint $table) {
            $table->id();
            $table->string('jobcard_number');
            $table->String('date');
            $table->String('branch');
            $table->string('customer_name');
            $table->string('email')->nullable();
            $table->string('phone');
            $table->string('customer_place')->nullable();
            $table->string('customer_type');
            $table->string('work_location')->nullable();
            $table->string('service_type')->nullable();
            $table->string('product_name')->nullable();
            $table->string('serial_no')->nullable();
            $table->text('complaints')->nullable();
            $table->text('components')->nullable();
            $table->text('remarks')->nullable();
            $table->string('advance')->nullable();
            $table->String('image1')->nullable();
            $table->String('image2')->nullable();
            $table->string('image3')->nullable();
            $table->string('image4')->nullable();
            $table->text('complaint_details')->nullable();
            $table->string('estimate')->nullable();
            $table->string('customer_relation')->nullable();
            $table->string('gst_no')->nullable();
            $table->string('payement_status')->nullable();
            $table->string('payement_method')->nullable();
            $table->string('invoice_no')->nullable();
            $table->string('approve_status')->default('pending');
            $table->string('status')->default('pending');
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
        Schema::dropIfExists('consignments');
    }
}
