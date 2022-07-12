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
        DB::table('brands')->insert(['name' => 'LG']);
        DB::table('brands')->insert(['name' => 'Samsung']);
        DB::table('brands')->insert(['name' => 'Elgin']);
        DB::table('brands')->insert(['name' => 'Midea']);
        DB::table('brands')->insert(['name' => 'Carrier']);
        DB::table('brands')->insert(['name' => 'Electrolux']);
    }
}
