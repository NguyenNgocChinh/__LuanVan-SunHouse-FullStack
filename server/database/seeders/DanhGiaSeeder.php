<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class DanhGiaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $faker = Faker::create();
        for($index=1;$index<=20;$index++){
            DB::table('danhgia')->insert([
                'user_id' => rand(1,10),
                'baidang_id'=>rand(1,10),
                'sao' => rand(1,5),
                'noidung' => $faker->text(80),

            ]);

        }
    }
}
