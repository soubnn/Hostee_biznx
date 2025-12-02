<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCourierDeliveryAndCourierBillToChiplevelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('chiplevels', function (Blueprint $table) {
            $table->string('courier_delivery')->nullable()->after('chiplevel_complaint');
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
        Schema::table('chiplevels', function (Blueprint $table) {
            //
        });
    }
}
