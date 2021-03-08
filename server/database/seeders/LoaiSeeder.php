<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LoaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $loai = array('Căn hộ', 'Biệt thự', 'Nhà ở', 'Phòng trọ','Nhà mặt tiền');
        foreach($loai as $value){
            DB::table('loai')->insert(
                [
                    'ten_loai' => $value,
                ]
            );
        }
    }
}