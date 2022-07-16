<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('brands')->insert(['name' => 'LG']); //1
        DB::table('brands')->insert(['name' => 'Samsung']); //2
        DB::table('brands')->insert(['name' => 'Elgin']); //3
        DB::table('brands')->insert(['name' => 'Midea']); //4
        DB::table('brands')->insert(['name' => 'Carrier']); //5
        DB::table('brands')->insert(['name' => 'Electrolux']); //6
        DB::table('brands')->insert(['name' => 'Hitachi']); //7
        DB::table('brands')->insert(['name' => 'Komeco']); //8
        DB::table('brands')->insert(['name' => 'Coolix']); //9
        DB::table('brands')->insert(['name' => 'Tempstar']); //10
        DB::table('brands')->insert(['name' => 'Agratto']); //11
    }
}
