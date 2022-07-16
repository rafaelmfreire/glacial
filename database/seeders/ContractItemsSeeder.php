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
            'number'     => '006',
            'title'      => 'SERVIÇO DE INSTALAÇÃO DE SPLIT DE 28.000 A 40.000 BTU/H. DISTANCIA DA TUBULAÇÃO DE COBRE ATÉ 3 METROS.',
            'item_value' => '38952',
        ]);
        DB::table('contract_items')->insert([
            'number'     => '010',
            'title'      => 'SERVIÇO DE INSTALAÇÃO DE SPLIT DE 7.000 A 12.000 BTU/H. DISTANCIA DA TUBULAÇÃO DE ATÉ 3 METROS.',
            'item_value' => '27823',
        ]);
        DB::table('contract_items')->insert([
            'number'     => '014',
            'title'      => 'SERVIÇO DE INSTALAÇÃO E FIXAÇÃO COM FORNECIMENTO DE CABO PP, COMPATIVEL COM A CAPACIDADDE DE BTUS DOS SPLIT MINIMO: 3X2,5MM²',
            'item_value' => '445',
        ]);
        DB::table('contract_items')->insert([
            'number'     => '022',
            'title'      => 'SERVIÇO DE INSTALAÇÃO E FIXAÇÃO DE DUTOS DE COBRE 3/4 POLEGADA, PARA REFRIGERAÇÃO',
            'item_value' => '2789',
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
        DB::table('contract_items')->insert([
            'number'     => '043',
            'title'      => 'SERVIÇO DE ISOLAMENTO TERMICO COM FORNECIMENTO DA FITA PVC PARA ISOLAMENTO DE REFRIGERAÇÃO AR CONDICIONADO SPLIT',
            'item_value' => '556',
        ]);
        DB::table('contract_items')->insert([
            'number'     => '069',
            'title'      => 'SERVIÇO DE MANUTENÇÃO CORRETIVA EM SPLIT DE 15.000 A 24.000 BTU/H FORNECIMENTO E SUBSTITUIÇÃO GABINETE',
            'item_value' => '13355',
        ]);
        DB::table('contract_items')->insert([
            'number'     => '189',
            'title'      => 'SERVIÇO DE MANUTENÇÃO CORRETIVA EM SPLIT DE 28.000 A 40.000 BTU/H, CARGA DE GÁS REFRIGERANTE COM CORREÇÃO DE VAZAMENTO(S)',
            'item_value' => '13355',
        ]);
        DB::table('contract_items')->insert([
            'number'     => '193',
            'title'      => 'SERVIÇO DE MANUTENÇÃO CORRETIVA EM SPLIT DE 48.000 A 60.000 BTU/H CARGA DE GÁS REFRIGERANTE COM CORREÇÃO DE VAZAMENTO(S)',
            'item_value' => '16694',
        ]);
        DB::table('contract_items')->insert([
            'number'     => '272',
            'title'      => 'SERVIÇO DE MANUTENÇÃO CORRETIVA EM SPLIT DE 7.000 A 12.000 BTU/H FORNECIMENTO E SUBSTITUIÇÃO CAPACITOR FASE COMPRESSOR. ',
            'item_value' => '5565',
        ]);
        DB::table('contract_items')->insert([
            'number'     => '276',
            'title'      => 'SERVIÇO DE MANUTENÇÃO CORRETIVA EM SPLIT DE 7.000 A 12.000 BTU/H FORNECIMENTO E SUBSTITUIÇÃO CAPACITOR FASE VENTILADOR. ',
            'item_value' => '5008',
        ]);
        DB::table('contract_items')->insert([
            'number'     => '334',
            'title'      => 'SERVIÇO DE MANUTENÇÃO CORRETIVA EM SPLIT DE 7.000 A 12.000 BTU/H, CARGA DE GÁS REFRIGERANTE COM CORREÇÃO DE VAZAMENTO(S)',
            'item_value' => '20032',
        ]);
        DB::table('contract_items')->insert([
            'number'     => '337',
            'title'      => 'SERVIÇO DE MANUTENÇÃO PREVENTIVA E CORRETIVA EM SPLIT DE 15,000 A 24,000 BTU/H. LIMPEZA SIMPLES NO LOCAL.',
            'item_value' => '11129',
        ]);
        DB::table('contract_items')->insert([
            'number'     => '343',
            'title'      => 'SERVIÇO DE MANUTENÇÃO PREVENTIVA E CORRETIVA EM SPLIT DE 28,000 A 40,000 BTU/H. LIMPEZA SIMPLES NO LOCAL.',
            'item_value' => '11129',
        ]);
        DB::table('contract_items')->insert([
            'number'     => '345',
            'title'      => 'SERVIÇO DE MANUTENÇÃO PREVENTIVA E CORRETIVA EM SPLIT DE 28.000 A 40.000 BTU/H. LIMPEZA COM RETIRADA E REINSTALAÇÃO DO EQUIPAMENTO.',
            'item_value' => '27823',
        ]);
        DB::table('contract_items')->insert([
            'number'     => '349',
            'title'      => 'SERVIÇO DE MANUTENÇÃO PREVENTIVA E CORRETIVA EM SPLIT DE 48,000 A 60,000 BTU/H. LIMPEZA SIMPLES NO LOCAL. ',
            'item_value' => '14467',
        ]);
        DB::table('contract_items')->insert([
            'number'     => '356',
            'title'      => 'SERVIÇO DE MANUTENÇÃO PREVENTIVA E CORRETIVA EM SPLIT DE 7.000 A 12.000 BTU/H. LIMPEZA COM RETIRADA E REINSTALAÇÃO DO EQUIPAMENTO. ',
            'item_value' => '23371',
        ]);
        DB::table('contract_items')->insert([
            'number'     => '358',
            'title'      => 'SERVIÇO DE MANUTENÇÃO PREVENTIVA E CORRETIVA EM SPLIT DE 7.000 A 12.000 BTU/H. LIMPEZA SIMPLES NO LOCAL.',
            'item_value' => '11129',
        ]);
        DB::table('contract_items')->insert([
            'number'     => '364',
            'title'      => 'SERVIÇO DE REMOÇÃO DE SPLIT DE 28.000 A 40.000 BTU/H. ',
            'item_value' => '10016',
        ]);
        DB::table('contract_items')->insert([
            'number'     => '370',
            'title'      => 'SERVIÇO DE REMOÇÃO DE SPLIT DE 7.000 A 12.000 BTU/H. ',
            'item_value' => '10016',
        ]);
        //
    }
}
