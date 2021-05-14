<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class BinhLuanSeeder extends Seeder
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
        for ($index = 1; $index <= 20; $index++) {
            DB::table('binhluan')->insert([
                'user_id' => rand(1, 10),
                'baidang_id' => rand(1, 10),
                'noidung' => $faker->text(100),
                'created_at' => $faker->dateTime(),
            ]);
        }
    }
}