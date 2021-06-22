<?php

namespace Database\Seeders;

use App\Models\BaiDang;
use App\Models\Loai;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;

class BaiDangSeeder extends Seeder
{
    function mt_random_float($min, $max)
    {
        $float_part = mt_rand(0, mt_getrandmax()) / mt_getrandmax();
        $integer_part = mt_rand($min, $max - 1);
        return $integer_part + $float_part;
    }

    public function run()
    {
        $faker = Faker::create();
        $Huong = collect(['Đông', 'Tây', 'Nam', 'Bắc', 'Đông Bắc', 'Tây Bắc', 'Đông Nam', 'Tây Nam']);
        $loai = collect(Loai::all()->modelKeys());
        $user = collect(User::all()->modelKeys());

        $minY = 8.37;
        $maxY = 23.21;
        $minX = 105.18;
        $maxX = 109.27;
        $toadoX = '';
        $toadoY = '';

        $maxLoop = 20;
        $data = [];
        $location = [];
        for ($index = 1; $index <= $maxLoop; $index++) {
            $toadoX = $this->mt_random_float($minX, $maxX);
            $toadoY = $this->mt_random_float($minY, $maxY);
            $data[] = [
                'user_id' => $user->random(),
                'tieude' => 'Tiêu đề random số ' . $faker->numberBetween(1, $maxLoop),
                'noidung' => $faker->text(1000),
                'loai_id' => $loai->random(),
                'gia' => rand(3000, 8000),
                'trangthai' => rand(0, 1),
                'huong' => $Huong->random(),
                'isChoThue' => rand(0, 1),
                'sophongngu' => rand(1, 5),
                'sophongtam' => rand(1, 3),
                'namxaydung' => rand(1980, 2020),
                'diachi' => $faker->unique()->address,
                'toadoX' => $toadoX,
                'toadoY' => $toadoY,
                'choduyet' => 0,
                'dientich' => rand(50, 3000),
                'luotxem' => rand(1, 500),
                'created_at' => $faker->dateTime(),
            ];
        }
//        $chunks = array_chunk($data, 10);
//        foreach ($chunks as $chunk) {
//            DB::table('baidang')->insert($chunk);
//        }
        DB::table('baidang')->insert($data);

//        DB::table('baidang-hinhanh')->insert([
//            ['baidang_id' => 10,
//                'filename' => '10a.jpg'],
//            ['baidang_id' => 10,
//                'filename' => '10b.png'],
//            ['baidang_id' => 10,
//                'filename' => '10c.jpg'],
//            ['baidang_id' => 10,
//                'filename' => '10d.jpg'],
//
//        ]);
    }
}
