<?php

namespace Database\Factories;

use App\Models\Message;
use Illuminate\Database\Eloquent\Factories\Factory;

class MessageFactory extends Factory
{

    protected $model = Message::class;


    public function definition()
    {
        do {
            $from = rand(1, 10);
            $to = 11;
        } while ($from === $to);

        return [
            'from' => $from,
            'to' => $to,
            'noidung' => $this->faker->sentence
        ];
    }
}
