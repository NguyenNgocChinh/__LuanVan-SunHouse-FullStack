<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocationSeeder extends Seeder
{
    private function mt_random_float($min, $max)
    {
        $float_part = mt_rand(0, mt_getrandmax()) / mt_getrandmax();
        $integer_part = mt_rand($min, $max - 1);
        return $integer_part + $float_part;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        $minY = 8.37;
//        $maxY = 23.21;
//        $minX = 105.18;
//        $maxX = 109.27;
//        $data = null;
//
//        for ($index = 1; $index < 1000000; $index++) {
//            $toadoX = $this->mt_random_float($minX,$maxX);
//            $toadoY = $this->mt_random_float($minY,$maxY);
//            $data[] =  [
//                'baidang_id' => $index,
//                'position' => DB::raw("ST_GeomFromText('point($toadoX $toadoY)',4326)"),
//            ];
//        }
//        $chunks = array_chunk($data, 5000, true);
//        foreach ($chunks as $chunk)
//        {
//            DB::table('location')->insert($chunk);
//        }

        DB::select('call sp_seed_location');
        DB::select('call sp_seed_location_0');
    }
}
