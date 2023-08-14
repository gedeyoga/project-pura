<?php

namespace Database\Seeders;

use App\Models\District;
use App\Models\Province;
use App\Models\Regency;
use App\Models\Village;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use File;

class WilayahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Province::truncate();

        $json = File::get("database/provinces.json");
        $provinces = json_decode($json);

        foreach ($provinces as $key => $value) {
            Province::create([
                'id' => $value->id,
                "name" => $value->name
            ]);
        }

        Regency::truncate();
        $json = File::get("database/regencies.json");
        $provinces = json_decode($json);

        foreach ($provinces as $key => $value) {
            Regency::create([
                'id' => $value->id,
                'province_id' => $value->province_id,
                "name" => $value->name
            ]);
        }

        District::truncate();
        $json = File::get("database/districts.json");
        $provinces = json_decode($json);

        foreach ($provinces as $key => $value) {
            District::create([
                'id' => $value->id,
                'regency_id' => $value->regency_id,
                "name" => $value->name
            ]);
        }

        Village::truncate();
        $json = File::get("database/villages.json");
        $chunks = collect(json_decode($json))->chunk(200);

        foreach ($chunks as $provinces) {
            $new = $provinces->map(function ($item) {
                return [
                    'id' => $item->id,
                    'district_id' => $item->district_id,
                    'name' => $item->name,
                ];
            })->toArray();
            Village::insert($new);
        }
    }
}
