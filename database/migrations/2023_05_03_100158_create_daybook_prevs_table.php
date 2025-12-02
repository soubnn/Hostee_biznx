<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDaybookPrevsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daybook_prevs', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->String('expense')->nullable();
            $table->String('income')->nullable();
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
        Schema::dropIfExists('daybook_prevs');
    }
}
