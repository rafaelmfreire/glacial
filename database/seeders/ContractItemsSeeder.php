<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContractItemsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('contract_items')->insert([
            'number'     => '001',
            'title'      => 'SERVIÇO DE INSTALAÇÃO DE SPLIT DE 15.000 A 24.000 BTU/H. DISTANCIA DA TUBULAÇÃO DE ATÉ 3 METROS.',
            'item_value' => '33387',
        ]);
        DB::table('contract_items')->insert([
            'number'     => '014',
            'title'      => 'SERVIÇO DE INSTALAÇÃO E FIXAÇÃO COM FORNECIMENTO DE CABO PP, COMPATIVEL COM A CAPACIDADDE DE BTUS DOS SPLIT MINIMO: 3X2,5MM²',
            'item_value' => '445',
        ]);
        DB::table('contract_items')->insert([
            'number'     => '025',
            'title'      => 'SERVIÇO DE INSTALAÇÃO E FIXAÇÃO DE DUTOS DE COBRE 3/8 POLEGADA, PARA REFRIGERAÇÃO',
            'item_value' => '1113',
        ]);
        DB::table('contract_items')->insert([
            'number'     => '028',
            'title'      => 'SERVIÇO DE INSTALAÇÃO E FIXAÇÃO DE DUTOS DE COBRE 5/8 POLEGADA, PARA REFRIGERAÇÃO',
            'item_value' => '2226',
        ]);
        //
    }
}
