<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExpenseTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $expenses=array(array(
            'expense_name'=>'Fuel'
        ),
        array(
            'expense_name'=>'Food'
        ),
        array(
            'expense_name'=>'Travel Allowance'
        ),
        array(
            'expense_name'=>'Freight Charge'
        ),
        array(
            'expense_name'=>'Delivery Charge'
        ),
        array(
            'expense_name'=>'Miscellaneous Charge'
        ),);
        DB ::table('expenses')->insert($expenses);
    }
}
