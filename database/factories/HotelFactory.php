<?php

namespace Database\Factories;

use App\Models\Hotel;
use Illuminate\Database\Eloquent\Factories\Factory;

class HotelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Hotel::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->text(20),
            'description' => $this->faker->sentence(),
            'created_at' => $this->faker->dateTimeBetween('-20 days', '-10 days'),
            'updated_at' => $this->faker->dateTimeBetween('-5 days', '-1 days'),
           
        ];
    }
}