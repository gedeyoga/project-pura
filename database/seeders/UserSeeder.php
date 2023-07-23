<?php

namespace Database\Seeders;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();

        $data = [
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'password' => 'admin123',
            'remember_token' => null,
        ];

        $user_repo = app(UserRepository::class);

        $data['password'] = bcrypt($data['password']);
        $user = $user_repo->create($data);

        // $user_repo->createUserToken($user, 'auth_token');
    }
}
