<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstimatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estimates', function (Blueprint $table) {
            $table->id();
            $table->String('estimate_type');
            $table->String('estimate_date')->nullable();
            $table->String('valid_upto')->nullable();
            $table->String('customer_name')->nullable();
            $table->String('customer_phone')->nullable();
            $table->String('grand_total')->nullable();
            $table->String('generated_by')->nullable();
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
        Schema::dropIfExists('estimates');
    }
}
