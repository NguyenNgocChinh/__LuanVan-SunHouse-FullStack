<?php

namespace Database\Seeders;
use App\Models\Goi;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class GoiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($index=1;$index<=10;$index++){
            DB::table('goi')->insert([
                'ten' => 'Gói thứ'. $index,
                'gia' => rand(150,3000),
                'douutien'=>$index,
                'slbaidang' => 5 + $index,
                 'hansudung'=> $index + 3
            ]);
        }
    }
}