<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->String('date')->nullable();
            $table->String('name')->nullable();
            $table->String('company')->nullable();
            $table->String('contact')->nullable();
            $table->String('email')->nullable();
            $table->String('subject')->nullable();
            $table->text('message')->nullable();
            $table->String('status')->default('unread');
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
        Schema::dropIfExists('contacts');
    }
}
