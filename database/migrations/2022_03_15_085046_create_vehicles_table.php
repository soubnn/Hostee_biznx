<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {

            $table->id();
            $table->String('vehicle_number');
            $table->String('vehicle_name')->nullable();;
            $table->String('vehicle_model')->nullable();;
            $table->String('rc_owner')->nullable();
            $table->String('engine_number')->nullable();
            $table->String('chasis_number')->nullable();
            $table->String('reg_validity')->nullable();
            $table->String('insurance_number')->nullable();
            $table->String('insurance_validity')->nullable();
            $table->String('pollution_validity')->nullable();
            $table->String('permit_validity')->nullable();
            $table->String('rc_doc')->nullable();
            $table->String('insurance_doc')->nullable();
            $table->String('pollution_doc')->nullable();
            $table->String('permit_doc')->nullable();
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
        Schema::dropIfExists('vehicles');
    }
}
