<?php

namespace Database\Seeders;

use App\Models\SensorPintu;
use App\Models\Pura;
use App\Models\PuraNew;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class SensorPintuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        SensorPintu::truncate();
        $pura = Pura::first();
        $datas = [
            [
                'gs_nama' => 'Sensor Pintu 1', 
                'gs_sensor_pintu' => '0', 
                'pura_id' => $pura->id, 
            ],
            [
                'gs_nama' => 'Sensor Pintu 2', 
                'gs_sensor_pintu' => '0', 
                'pura_id' => $pura->id, 
            ],
        ];

        foreach ($datas as $data) {
            SensorPintu::create($data);
        }
        Schema::enableForeignKeyConstraints();

    }
}
