<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
class EmployeeCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category=array(array(
            'category_name'=>'Office Staff'
        ),
        array(
            'category_name'=>'Machinery Staff'
        ),
        array(
            'category_name'=>'Mechanic'
        ),
        array(
            'category_name'=>'Service Manager'
        ),
        array(
            'category_name'=>'Sales Manager'
        ),
        array(
            'category_name'=>'Servicer'
        ),
        array(
            'category_name'=>'Others'
        ),
        );
        DB::table('employee_categories')->insert($category);
    }
}
