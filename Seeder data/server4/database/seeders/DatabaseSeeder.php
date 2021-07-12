<?php

namespace Database\Seeders;

use App\Models\BaiDang;
use App\Models\Message;
use App\Models\ThongTinDangKy;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //User::factory(10)->create();

        $this->call(
            [
     //           UserSeeder::class,
          //      LoaiSeeder::class,
        //        TienNghiSeeder::class,
           //     BaiDangSeeder::class,
                LocationSeeder::class,
//                DanhGiaSeeder::class,
//                BinhLuanSeeder::class,

//                TinhThanhPhoSeeder::class,
//                QuanHuyenSeeder::class,
//                XaPhuongThiTranSeeder::class,
            ]
        );
      //  Message::factory(100)->create();
//        BaiDang::factory(3500000)->create();
    }
}
