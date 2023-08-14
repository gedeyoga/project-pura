<?php

namespace Database\Factories;

use App\Models\Pura;
use App\Models\SensorPintu;
use Illuminate\Database\Eloquent\Factories\Factory;

class SensorPintuFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SensorPintu::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'gs_nama' => $this->faker->word(), 
            'gs_sensor_pintu' => $this->faker->randomElement(['0' , '1']), 
            'pura_id' => Pura::factory()->create()->id, 
            'gs_kode_sensor' => null, 
            'guard_state' => $this->faker->randomElement(['0', '1']), 
            'token' => $this->faker->ean13(),
        ];
    }
}
