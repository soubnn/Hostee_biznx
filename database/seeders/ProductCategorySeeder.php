<?php

namespace Database\Seeders;

use App\Models\product_categories;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category=array(array(
            'category_name'=>'item1'
        ),
        array(
            'category_name'=>'item2'
        ),
        array(
            'category_name'=>'item3'
        ),
        array(
            'category_name'=>'Others'
        ),);
        DB::table('product_categories')->insert($category);
    }
}
