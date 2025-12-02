<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFieldPurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('field_purchases', function (Blueprint $table) {
            $table->id();
            $table->integer('field_id');
            $table->string('date');
            $table->string('product')->nullable();
            $table->string('seller');
            $table->string('amount');
            $table->string('qty')->nullable();
            $table->string('bill')->nullable();
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
        Schema::dropIfExists('field_purchases');
    }
}
