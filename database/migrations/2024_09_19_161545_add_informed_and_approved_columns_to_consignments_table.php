<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInformedAndApprovedColumnsToConsignmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('consignments', function (Blueprint $table) {
            $table->string('informed_staff')->nullable()->after('add_by');
            $table->dateTime('informed_date')->nullable()->after('informed_staff');
            $table->string('approved_staff')->nullable()->after('informed_date');
            $table->dateTime('approved_date')->nullable()->after('approved_staff');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('consignments', function (Blueprint $table) {
            //
        });
    }
}
