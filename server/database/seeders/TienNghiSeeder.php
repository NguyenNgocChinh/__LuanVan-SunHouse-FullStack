<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TienNghiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tiennghi = array('Điều hòa', 'Lò nướng', 'Phòng Gym', 'Tủ lạnh', 'Hồ Bơi');
        foreach ($tiennghi as $value) {
            DB::table('tiennghi')->insert(
                [
                    'ten_tiennghi' => $value,
                ]
            );
        }
    }
}