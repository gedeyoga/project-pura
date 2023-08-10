<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use App\Repositories\UserRepository;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class UserRepositoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_create_user()
    {
        $user = User::factory()->make()->toArray();

        Artisan::call('db:seed' , [
            'class' => 'RoleSeeder'
        ]);

        $user['password'] = '123235235534';
        $user['role'] = 'admin';

        $user_repo = app(UserRepository::class);

        $data = $user_repo->createUser($user);

        $this->assertEquals($user['name'] , $data->name);
        $this->assertNotNull($data->getAuthToken());
        $this->assertNotNull($data->hasRole('admin'));
    }

    public function test_update_user()
    {

        $this->test_create_user();

        $user = User::first();

        $data = [
            'role' => 'user'
        ];

        $user_repo = app(UserRepository::class);

        $data = $user_repo->updateUser($user , $data);

        $this->assertEquals($user['name'], $data->name);
        $this->assertNotNull($data->getAuthToken());
        $this->assertNotNull($data->hasRole('user'));
    }


    public function test_delete_user()
    {

        $this->test_update_user();

        $user = User::first();

        $user_repo = app(UserRepository::class);

        $data = $user_repo->deleteUser($user);

        $this->assertTrue($data);
    }
}
