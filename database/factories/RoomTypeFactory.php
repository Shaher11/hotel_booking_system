<?php

namespace Database\Factories;

use App\Models\RoomType;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoomTypeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = RoomType::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'size' => $this->faker->numberBetween(1,5),
            'price' => $this->faker->numberBetween(100,500),
            'available' => $this->faker->numberBetween(1,10),       // available amount of rooms
            'created_at' => $this->faker->dateTimeBetween('-9 days', '-4 days'),
            'updated_at' => $this->faker->dateTimeBetween('-2 days', '-1 minute'),

        ];
    }
}