<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCourierDeliveryAndCourierBillToWarrentiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('warrenties', function (Blueprint $table) {
            $table->string('courier_delivery')->nullable()->after('warrenty_complaint');
            $table->string('courier_bill')->nullable()->after('courier_delivery');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('warrenties', function (Blueprint $table) {
            //
        });
    }
}
