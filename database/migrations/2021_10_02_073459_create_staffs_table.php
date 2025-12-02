<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaffsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staffs', function (Blueprint $table) {
            $table->id();
            $table->integer('category_id')->unsigned();
            $table->string('staff_name');
            $table->string('phone1');
            $table->string('phone2')->nullable();
            $table->date('dob')->nullable();
            $table->string('email')->nullable();
            $table->string('salary')->nullable();
            $table->text('address')->nullable();
            $table->text('remark')->nullable();
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
        Schema::dropIfExists('staffs');
    }
}
