<?php

namespace Database\Factories;

use App\Models\BaiDang;
use Illuminate\Database\Eloquent\Factories\Factory;

class BaiDangFactory extends Factory
{
    private $Huong = array('Đông', 'Tây', 'Nam', 'Bắc', 'Đông Bắc', 'Tây Bắc', 'Đông Nam', 'Tây Nam');
    private $minY = 8.37;
    private $maxY = 23.21;
    private $minX = 105.18;
    private $maxX = 109.27;

    private function mt_random_float($min, $max)
    {
        $float_part = mt_rand(0, mt_getrandmax()) / mt_getrandmax();
        $integer_part = mt_rand($min, $max - 1);
        return $integer_part + $float_part;
    }

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BaiDang::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => rand(5, 10),
            'tieude' => $this->faker->word(100),
            'noidung' => $this->faker->text(1000),
            'loai_id' => rand(1, 5),
            'gia' => rand(3000, 8000),
            'trangthai' => rand(0, 1),
            'huong' => $this->Huong[rand(0, 7)],
            'isChoThue' => rand(0, 1),
            'sophongngu' => rand(1, 5),
            'sophongtam' => rand(1, 3),
            'namxaydung' => rand(1980, 2020),
            'diachi' => $this->faker->address(),
            'toadoX' => $this->mt_random_float($this->minX, $this->maxX),
            'toadoY' => $this->mt_random_float($this->minY, $this->maxY),
            'choduyet' => 0,
            'dientich' => rand(50, 3000),
            'luotxem' => rand(1, 500),
            'created_at' => $this->faker->dateTime(),
        ];
    }
}
