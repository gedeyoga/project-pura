<?php

namespace Database\Factories;

use App\Models\Pura;
use Illuminate\Database\Eloquent\Factories\Factory;

class PuraFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Pura::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'pura_nama' => $this->faker->name, 
            'pura_alamat' => $this->faker->address, 
            'pura_lat' => $this->faker->randomDigit, 
            'pura_lng' => $this->faker->randomDigit, 
            'jp_id' => $this->faker->randomDigit, 
            'kel_id' => $this->faker->randomDigit, 
            'pura_ip' => $this->faker->ipv6,
        ];
    }
}
