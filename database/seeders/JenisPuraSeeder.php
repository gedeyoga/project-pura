<?php

namespace Database\Seeders;

use App\Models\JenisPura;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class JenisPuraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        JenisPura::truncate();
        
        $data = [
            [
                'jp_nama' => 'Pura Kahyangan Jagat',
                'jp_active' => 'y'
            ],
            [
                'jp_nama' => 'Pura Dang Kahyangan Jagat',
                'jp_active' => 'y'
            ],
            [
                'jp_nama' => 'Pura Kahyangan Tiga',
                'jp_active' => 'y'
            ],
            [
                'jp_nama' => 'Pura Swagina',
                'jp_active' => 'y'
            ],
            [
                'jp_nama' => 'Pura Kawitan',
                'jp_active' => 'y'
            ],
            [
                'jp_nama' => 'Pura Desa',
                'jp_active' => 'y'
            ],
            [
                'jp_nama' => 'Pura Puseh',
                'jp_active' => 'y'
            ],
            [
                'jp_nama' => 'Pura Dalem',
                'jp_active' => 'y'
            ],
        ];

        JenisPura::insert($data);
        Schema::enableForeignKeyConstraints();
    }
}
