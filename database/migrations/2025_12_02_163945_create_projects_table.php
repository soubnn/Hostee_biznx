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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('project_name');
            $table->string('customer')->nullable();
            $table->string('given_by')->nullable();
            $table->text('project_description')->nullable();
            $table->string('start_date')->nullable();
            $table->string('end_date')->nullable();
            $table->string('budget')->nullable();
            $table->string('team_leader')->nullable();
            $table->string('team_members')->nullable();
            $table->string('attachment1')->nullable();
            $table->string('attachment2')->nullable();
            $table->string('attachment3')->nullable();
            $table->string('attachment4')->nullable();
            $table->string('payment_status')->default('pending');
            $table->string('status')->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
