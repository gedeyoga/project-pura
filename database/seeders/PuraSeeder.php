<?php

namespace Database\Seeders;

use App\Models\JenisPura;
use App\Models\Pura;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class PuraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        Pura::truncate();

        $user = User::first();

        $datas = [
            [
                'pura_nama' => 'Pura Besakih', 
                'pura_alamat' => 'Jalan Besakih', 
                'pura_lat' =>  1.00, 
                'pura_lng' =>  2.00, 
                'jp_id' => JenisPura::where('jp_nama' , 'Pura Puseh')->first()->id, 
                'kel_id' => null, 
                'pura_ip' => '192.168.1.12', 
                'pura_sensor_cctv' => '0',
            ],
            [
                'pura_nama' => 'Pura Sakenan', 
                'pura_alamat' => 'Jalan Sakenan', 
                'pura_lat' =>  1.00, 
                'pura_lng' =>  2.00, 
                'jp_id' => JenisPura::where('jp_nama' , 'Pura Puseh')->first()->id, 
                'kel_id' => null, 
                'pura_ip' => '192.168.1.12', 
                'pura_sensor_cctv' => '0',
            ],
        ];

        foreach ($datas as $data) {
            $pura = Pura::create($data);

            $user->pura()->attach($pura);
        }

        Schema::enableForeignKeyConstraints();
    }
}
