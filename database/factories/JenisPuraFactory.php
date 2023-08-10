<?php

namespace Database\Factories;

use App\Models\JenisPura;
use Illuminate\Database\Eloquent\Factories\Factory;

class JenisPuraFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = JenisPura::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'jp_nama' => $this->faker->name,
            'jp_active' => $this->faker->randomElement(['n' , 'y']),
        ];
    }
}
