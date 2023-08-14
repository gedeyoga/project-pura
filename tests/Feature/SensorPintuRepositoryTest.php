<?php

namespace Tests\Feature;

use App\Events\SensorPintuActive;
use App\Events\SensorPintuNotActive;
use App\Models\SensorPintu;
use App\Repositories\SensorPintuRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class SensorPintuRepositoryTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testUpdateSensorPintuActive()
    {
        $repo = app(SensorPintuRepository::class);

        $data = SensorPintu::factory()->create();

        Event::fake();

        $rs = $repo->update($data, [
            'gs_sensor_pintu' => 1,
        ]);

        Event::assertDispatched(SensorPintuActive::class , function($event) use ($data) {
            return $event->sensor_pintu->id == $data->id;
        });

        $this->assertEquals(1, $rs->gs_sensor_pintu);
    }

    public function testUpdateSensorPintuNotActive()
    {
        $repo = app(SensorPintuRepository::class);

        $data = SensorPintu::factory()->create();

        Event::fake();

        $rs = $repo->update($data, [
            'gs_sensor_pintu' => 0,
        ]);

        Event::assertDispatched(SensorPintuNotActive::class, function ($event) use ($data) {
            return $event->sensor_pintu->id == $data->id;
        });

        $this->assertEquals(0, $rs->gs_sensor_pintu);
    }
}
