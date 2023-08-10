<?php

namespace Tests\Feature;

use App\Models\FotoPura;
use App\Models\JenisPura;
use App\Models\Pura;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PuraControllerTest extends TestCase
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

        $token = $repo->createUserToken($user , 'auth');

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
    public function testCreatePuraApi()
    {
        $data_user = $this->createUser();

        Storage::fake('local');

        $data = Pura::factory()->make([
            'jp_id' => JenisPura::factory()->create()->id,
        ])->toArray();

        $data['foto_puras'] = [
            [
                'file' => UploadedFile::fake()->image('foto_pura1.jpg'),
                'fp_keterangan' => 'Foto Gerbang',
            ],
        ];

        $headers = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token,
        ];

        $response = $this->post(route('api.pura.store') , $data , $headers);

        $response->assertStatus(200);
        $response->assertJsonStructure(['message','data']);
        $response->assertJson([
            'data' => [
                'pura_nama' => $data['pura_nama'],
                'jp_id' => $data['jp_id'],
            ]
        ]);
        $this->assertCount(1, FotoPura::all());
    }

    public function testUpdatePuraApi()
    {
        $this->testCreatePuraApi();

        Storage::fake('local');

        $pura = Pura::first();

        $data = Pura::factory()->make([
            'jp_id' => JenisPura::factory()->create()->id,
        ])->toArray();

        $data['foto_puras'] = FotoPura::all()->toArray();

        array_push($data['foto_puras'], [
            'file' => UploadedFile::fake()->image('foto_pura2.jpg'),
            'fp_keterangan' => 'Foto Gerbang 2',
        ]);

        $headers = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token,
        ];

        $response = $this->put(route('api.pura.update' , [
            'pura' => $pura->id,
        ]) , $data , $headers);

        $response->assertStatus(200);
        $response->assertJsonStructure(['message','data']);
        $response->assertJson([
            'data' => [
                'pura_nama' => $data['pura_nama'],
                'jp_id' => $data['jp_id'],
            ]
        ]);
        $this->assertCount(2, FotoPura::all());
    }

    public function testShowPuraApi()
    {
        $this->testUpdatePuraApi();

        $pura = Pura::first();

        $headers = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token,
        ];

        $response = $this->get(route('api.pura.show', [
            'pura' => $pura->id,
        ]), [], $headers);

        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'pura_nama' => $pura->pura_nama, 
                'pura_alamat' => $pura->pura_alamat, 
                'pura_lat' => $pura->pura_lat, 
                'pura_lng' => $pura->pura_lng, 
                'jp_id' => $pura->jp_id, 
                'kel_id' => $pura->kel_id, 
                'pura_ip' => $pura->pura_ip,
            ]
        ]);

        $response->assertJsonStructure([
            'data' => [
                'pura_nama', 'pura_alamat', 'pura_lat', 'pura_lng', 'jp_id', 'kel_id', 'pura_ip', 'foto_pura', 'jenis_pura'
            ]
        ]);
    }

    public function testDeletePuraApi()
    {
        $this->testUpdatePuraApi();

        $pura = Pura::first();

        $headers = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token,
        ];

        $response = $this->delete(route('api.pura.destroy' , [
            'pura' => $pura->id,
        ]) , [] , $headers);

        $response->assertStatus(200);
        $response->assertJsonStructure(['message']);
        $this->assertCount(0, FotoPura::all());
        $this->assertCount(0, Pura::all());
    }

}
