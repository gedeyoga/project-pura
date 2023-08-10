<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        Role::truncate();
        $roles = [
            [
                'name' => 'admin',
                'guard_name' => 'sanctum'
            ],
            [
                'name' => 'user',
                'guard_name' => 'sanctum'
            ]
        ];

        foreach ($roles as $item) {
            Role::create([
                'name' => $item['name'],
                'guard_name' => $item['guard_name']
            ]);
        }
        Schema::enableForeignKeyConstraints();
    }
}
