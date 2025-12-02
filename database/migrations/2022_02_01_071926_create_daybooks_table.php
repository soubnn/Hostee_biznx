<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDaybooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daybooks', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->String('expense_id')->nullable();
            $table->String('income_id')->nullable();
            $table->string('job')->nullable();
            $table->string('staff')->nullable();
            $table->String('amount');
            $table->String('type')->nullable();
            $table->String('accounts')->nullable();
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
        Schema::dropIfExists('daybooks');
    }
}
