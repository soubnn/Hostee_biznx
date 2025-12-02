<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user=array(
            'name'=>'TEST USER',
            'email'=>'test@gmail.com',
            'username'=>'test',
            'password'=>Hash::make('1123'),
            'role'=>'marketing',
            'image'=>'1634577671.img-5.png'


        );
        DB::table('users')->insert($user);
    }
}
