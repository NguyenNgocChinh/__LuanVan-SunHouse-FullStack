<?php

namespace Database\Seeders;

use App\Models\BaiDang;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BaiDangSeeder extends Seeder
{
    function mt_random_float($min, $max) {
        $float_part = mt_rand(0, mt_getrandmax())/mt_getrandmax();
        $integer_part = mt_rand($min, $max - 1);
        return $integer_part + $float_part;
    }
    public function run()
    {
        $faker = Faker::create();
        $Huong = array('Đông', 'Tây', 'Nam', 'Bắc', 'Đông Bắc', 'Tây Bắc', 'Đông Nam', 'Tây Nam');
        $minY = 8.538;
        $maxY = 23.387;
        $minX = 102.146;
        $maxX = 109.380;
        for ($index = 1; $index <= 20; $index++) {
            $Huong_key = rand(0, 7);
            BaiDang::create([
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
                'toadoX' => $this->mt_random_float($minX, $maxX),
                'toadoY' => $this->mt_random_float($minY, $maxY),
                'choduyet' => 0,
                'dientich' => rand(50, 3000),
                'luotxem' => rand(1, 500),
                'created_at' => $faker->dateTime(),
            ]);
        }
        DB::table('baidang-hinhanh')->insert([
            ['baidang_id' => 10,
                'filename' => '10a.jpg'],
            ['baidang_id' => 10,
                'filename' => '10b.png'],
            ['baidang_id' => 10,
                'filename' => '10c.jpg'],
            ['baidang_id' => 10,
                'filename' => '10d.jpg'],

        ]);
    }
}
