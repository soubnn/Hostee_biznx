<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDaybookSummariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daybook_summaries', function (Blueprint $table) {
            $table->id();
            $table->String('date');
            $table->String('opening_cash')->nullable();
            $table->String('opening_account')->nullable();
            $table->String('opening_ledger')->nullable();
            $table->String('closing_cash')->nullable();
            $table->String('closing_account')->nullable();
            $table->String('closing_ledger')->nullable();
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
        Schema::dropIfExists('daybook_summaries');
    }
}
