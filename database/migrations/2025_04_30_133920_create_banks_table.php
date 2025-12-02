<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('banks', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('bank_name');
            $table->string('acc_no')->nullable();
            $table->string('book_no')->nullable();
            $table->string('biller_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('opening_balance')->default('0');
            $table->string('status')->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banks');
    }
};
