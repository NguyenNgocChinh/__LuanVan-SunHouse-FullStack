<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BaiDangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $Huong = array('Đông', 'Tây', 'Nam', 'Bắc', 'Đông Bắc', 'Tây Bắc', 'Đông Nam', 'Tây Nam');
        for ($index = 1; $index <= 20; $index++) {
            $Huong_key = rand(0, 7);
            DB::table('baidang')->insert([
                'user_id' => rand(5, 10),
                'tieude' => 'Bài viết thứ ' . $faker->unique()->numberBetween(1, 20),
                'noidung' => $faker->text(1000),
                'loai_id' => rand(1, 5),
                'gia' => rand(3000, 8000),
                'trangthai' => rand(0, 1),
                'huong' => $Huong[$Huong_key],
                'isChoThue' => rand(0, 1),
                'sophongngu' => rand(1, 5),
                'sophongtam' => rand(1, 3),
                'namxaydung' => rand(1980, 2020),
                'diachi' => $faker->unique()->address,
                'toadoX' => rand(1, 100),
                'toadoY' => rand(1, 100),
                'choduyet' => 0,
                'dientich' => rand(50, 3000),
                'id_goi' => rand(5, 10),
                'created_at' => $faker->dateTime(),
            ]);
        }
    }
}
