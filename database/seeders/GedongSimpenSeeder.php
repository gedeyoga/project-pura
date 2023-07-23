<?php

namespace Database\Seeders;

use App\Models\GedongSimpen;
use App\Models\Pura;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class GedongSimpenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        GedongSimpen::truncate();
        $pura = PuraNew::first();
        $datas = [
            [
                'gs_nama' => 'Gedong Suci 1', 
                'gs_sensor_pintu' => '0', 
                'pura_id' => $pura->id, 
            ],
            [
                'gs_nama' => 'Gedong Suci 2', 
                'gs_sensor_pintu' => '0', 
                'pura_id' => $pura->id, 
            ],
        ];

        foreach ($datas as $data) {
            GedongSimpen::create($data);
        }
        Schema::enableForeignKeyConstraints();

    }
}
