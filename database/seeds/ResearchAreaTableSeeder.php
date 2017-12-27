<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ResearchAreaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $areas = [
            '教育學門',
            '藝術學門',
            '人文學門',
            '設計學門',
            '社會及行為科學學門',
            '傳播學門',
            '商業及管理學門',
            '法律學門',
            '生命科學學門',
            '自然科學學門',
            '數學及統計學門',
            '電算機學門',
            '工程學門',
            '建築及都市規劃學門',
            '農業科學學門',
            '獸醫學門',
            '醫藥衛生學門',
            '社會服務學門',
            '民生學門',
            '運輸服務學門',
            '環境保護學門',
        ];

        DB::table('research_area')->truncate();

        foreach ($areas as $area){
            DB::table('research_area')
                ->insert([
                    'area' => $area,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ]);
        }
    }
}
