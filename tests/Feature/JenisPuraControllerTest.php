<?php

namespace Tests\Feature;

use App\Models\JenisPura;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class JenisPuraControllerTest extends TestCase
{
    protected $user, $token;

    public function setUp(): void
    {
        parent::setUp();

        //Setup bearer token
        $data_user = $this->createUser();

        $this->user = $data_user['user'];
        $this->token = $data_user['token'];
    }
    public function createUser()
    {
        $repo = app(UserRepository::class);
        $user = User::factory()->create();

        $token = $repo->createUserToken($user, 'auth');

        return [
            'user' => $user,
            'token' => $token,
        ];
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCreateJenisPuraApi()
    {
        $data_user = $this->createUser();

        Storage::fake('local');

        $data = JenisPura::factory()->make()->toArray();

        $headers = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token,
        ];

        $response = $this->post(route('api.jenis-pura.store'), $data, $headers);

        $response->assertStatus(200);
        $response->assertJsonStructure(['message', 'data']);
        $response->assertJson([
            'data' => [
                'jp_nama' => $data['jp_nama'],
                'jp_active' => $data['jp_active'],
            ]
        ]);
        $this->assertCount(1, JenisPura::all());
    }

    public function testUpdateJenisPuraApi()
    {
        $this->testCreateJenisPuraApi();

        $jenis_pura = JenisPura::first();

        $data = JenisPura::factory()->make()->toArray();

        $headers = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token,
        ];

        $response = $this->put(route('api.jenis-pura.update', [
            'jenis_pura' => $jenis_pura->id,
        ]), $data, $headers);

        $response->assertStatus(200);
        $response->assertJsonStructure(['message', 'data']);
        $response->assertJson([
            'data' => [
                'jp_nama' => $data['jp_nama'],
                'jp_active' => $data['jp_active'],
            ]
        ]);
        $this->assertCount(1, JenisPura::all());
    }

    public function testShowJenisPuraApi()
    {
        $this->testUpdateJenisPuraApi();

        $jenis_pura = JenisPura::first();

        $headers = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token,
        ];

        $response = $this->get(route('api.jenis-pura.show', [
            'jenis_pura' => $jenis_pura->id,
        ]), [], $headers);

        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'jp_nama' => $jenis_pura->jp_nama,
                'jp_active' => $jenis_pura->jp_active
            ]
        ]);
    }

    public function testDeleteJenisPuraApi()
    {
        $this->testUpdateJenisPuraApi();

        $jenis_pura = JenisPura::first();

        $headers = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token,
        ];

        $response = $this->delete(route('api.jenis-pura.destroy', [
            'jenis_pura' => $jenis_pura->id,
        ]), [], $headers);

        $response->assertStatus(200);
        $response->assertJsonStructure(['message']);
        $this->assertCount(0, JenisPura::all());
    }
}
