<?php

namespace Database\Seeders;

use App\Models\Unidade;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnidadeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('unidades')->insert(
            [
                    ['nome' => 'Diretoria Geral', 'prefixo' => 'DGL'],
                    ['nome' => 'IP Alto Alegre do Pindaré', 'prefixo' => 'IP-AAP'],
                    ['nome' => 'IP Amarante do Maranhão', 'prefixo' => 'IP-AMA'],
                    ['nome' => 'IP Axixá', 'prefixo' => 'IP-AXI'],
                    ['nome' => 'IP Bacabal', 'prefixo' => 'IP-BCL'],
                    ['nome' => 'IP Bacabeira', 'prefixo' => 'IP-BBR'],
                    ['nome' => 'IP Balsas', 'prefixo' => 'IP-BLS'],
                    ['nome' => 'IP Brejo', 'prefixo' => 'IP-BJR'],
                    ['nome' => 'IP Carutapera', 'prefixo' => 'IP-CTR'],
                    ['nome' => 'IP Chapadinha', 'prefixo' => 'IP-CHD'],
                    ['nome' => 'IP Codó', 'prefixo' => 'IP-COD'],
                    ['nome' => 'IP Coelho Neto', 'prefixo' => 'IP-CNT'],
                    ['nome' => 'IP Colinas', 'prefixo' => 'IP-CLN'],
                    ['nome' => 'IP Coroatá', 'prefixo' => 'IP-CRT'],
                    ['nome' => 'IP Cururupu', 'prefixo' => 'IP-CRP'],
                    ['nome' => 'IP Matões', 'prefixo' => 'IP-MTS'],
                    ['nome' => 'IP Pindaré-Mirim', 'prefixo' => 'IP-PIM'],
                    ['nome' => 'IP Presidente Dutra', 'prefixo' => 'IP-PRD'],
                    ['nome' => 'IP Santa Helena', 'prefixo' => 'IP-STH'],
                    ['nome' => 'IP Santa Inês', 'prefixo' => 'IP-STS'],
                    ['nome' => 'IP Santa Luzia do Paruá', 'prefixo' => 'IP-SLP'],
                    ['nome' => 'IP São José de Ribamar', 'prefixo' => 'IP-SJR'],
                    ['nome' => 'IP São Luís Bacelar Portela', 'prefixo' => 'IP-BAP'],
                    ['nome' => 'IP São Luís Centro', 'prefixo' => 'IP-SLC'],
                    ['nome' => 'IP São Luís Gonçalves dias', 'prefixo' => 'IP-GDS'],
                    ['nome' => 'IP São Luís Itaqui Bacanga', 'prefixo' => 'IP-ITB'],
                    ['nome' => 'IP São Luís Rio Anil', 'prefixo' => 'IP-RIA'],
                    ['nome' => 'IP São Luís Tamancão', 'prefixo' => 'IP-TMC'],
                    ['nome' => 'IP São Vicente Ferrer', 'prefixo' => 'IP-SVF'],
                    ['nome' => 'IP Timon', 'prefixo' => 'IP-TIM'],
                    ['nome' => 'IP Tutóia', 'prefixo' => 'IP-TUT'],
                    ['nome' => 'IP Vargem Grande', 'prefixo' => 'IP-VGD'],
                    ['nome' => 'IP Viana', 'prefixo' => 'IP-ZDC'],
                    ['nome' => 'IP Zé Doca', 'prefixo' => 'IP-AAP'],

            ]
        );
    }
}
