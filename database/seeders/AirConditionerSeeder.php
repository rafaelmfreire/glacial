<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AirConditionerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('air_conditioners')->insert([
            'room'       => 'I11 Setor II',
            'identifier' => '2010664711',
            'cpf'        => '347',
            'brand_id'   => '2',
            'btu'        => '24000',
        ]);
        DB::table('air_conditioners')->insert([
            'room'       => 'C3 Supervisão',
            'identifier' => '2015041856',
            'cpf'        => '1420',
            'brand_id'   => '5',
            'btu'        => '36000',
        ]);
        DB::table('air_conditioners')->insert([
            'room'       => 'F3 Setor II',
            'identifier' => '2009059380',
            'cpf'        => '593',
            'brand_id'   => '7',
            'btu'        => '36000',
        ]);
        DB::table('air_conditioners')->insert([
            'room'       => 'C4 Setor II',
            'identifier' => '2007035263',
            'cpf'        => '4097',
            'brand_id'   => '8',
            'btu'        => '48000',
        ]);
        DB::table('air_conditioners')->insert([
            'room'       => 'B1 Setor II',
            'identifier' => '2014060747',
            'cpf'        => '1391',
            'brand_id'   => '7',
            'btu'        => '58000',
        ]);
        DB::table('air_conditioners')->insert([
            'room'       => 'A2 Setor II',
            'identifier' => '2009011903',
            'cpf'        => '139',
            'brand_id'   => '5',
            'btu'        => '60000',
        ]);
        DB::table('air_conditioners')->insert([
            'room'       => 'C5 Setor II',
            'identifier' => '2017017771',
            'cpf'        => '4098',
            'brand_id'   => '5',
            'btu'        => '60000',
        ]);
        DB::table('air_conditioners')->insert([
            'room'       => 'B3 Setor II',
            'identifier' => '2009059384',
            'cpf'        => '1347',
            'brand_id'   => '7',
            'btu'        => '36000',
        ]);
        DB::table('air_conditioners')->insert([
            'room'       => 'B3 Setor II',
            'identifier' => '2009059374',
            'cpf'        => '1348',
            'brand_id'   => '7',
            'btu'        => '36000',
        ]);
        //
    }
}
