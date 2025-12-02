<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarketingSummariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('marketing_summaries', function (Blueprint $table) {
            $table->id();
            $table->String('employee_id');
            $table->String('date');
            $table->integer('no_of_customers');
            $table->String('total_fuel_amount')->default(0);
            $table->String('total_km')->default(0);
            $table->String('image')->nullable();
            $table->String('status')->default('pending');
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
        Schema::dropIfExists('marketing_summaries');
    }
}
