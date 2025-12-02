<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWarrentiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('warrenties', function (Blueprint $table) {
            $table->id();
            $table->integer('jobcard_id');
            $table->String('shop_name');
            $table->String('service_date');
            $table->String('servicer_contact')->nullable();
            $table->String('staff_name')->nullable();
            $table->String('warrenty_complaint')->nullable();
            $table->String('service_charge')->nullable();
            $table->String('return_date')->nullable();
            $table->String('handover_staff')->nullable();
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
        Schema::dropIfExists('warrenties');
    }
}
