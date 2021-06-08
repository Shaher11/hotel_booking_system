<?php

namespace Database\Factories;
use HasFactory;
use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoomFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Room::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => rtrim( ucfirst($this->faker->text(20)), '.'),
            'description' => $this->faker->sentence(),
            'created_at' => $this->faker->dateTimeBetween('-10 days', '-5 days'),
            'updated_at' => $this->faker->dateTimeBetween('-3 days', '-1 hour'),
            'room_type_id' => RoomType::factory()->create(),
        ];
    }
}