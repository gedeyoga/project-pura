<?php

namespace Tests\Feature;

use App\Models\Pura;
use App\Repositories\PuraRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PuraRepositoryTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCreatePura()
    {
        $repo = app(PuraRepository::class);
        $data = Pura::factory()->make()->toArray();

        $data['foto_puras'] = [
            [
                'fp_url' => 'http://google.com/',
                'fp_keterangan' => 'foto_1',
            ]
        ];

        $rs = $repo->createPura($data);

        $this->assertEquals($data['pura_nama'] , $rs->pura_nama);
        $this->assertEquals($data['pura_alamat'] , $rs->pura_alamat);
        $this->assertEquals($data['jp_id'] , $rs->jp_id);
        $this->assertCount(1 , $rs->foto_pura);
    }

    public function testUpdatePura()
    {
        $this->testCreatePura();

        $repo = app(PuraRepository::class);
        $pura = Pura::first();

        $rs = $repo->updatePura($pura, [
            'pura_nama' => 'Pura Besakih',
            'foto_puras' => [
                [
                    'fp_url' => 'http://google.com/',
                    'fp_keterangan' => 'foto 1',
                ],
                [
                    'fp_url' => 'http://google.com/',
                    'fp_keterangan' => 'foto 2',
                ],
            ]
            
        ]);

        $this->assertEquals('Pura Besakih', $rs->pura_nama);
        $this->assertCount(2, $rs->foto_pura);
    }

    public function testDeletePura()
    {
        $this->testUpdatePura();
        $repo = app(PuraRepository::class);
        $pura = Pura::first();

        $repo->deletePura($pura);

        $this->assertCount(0, $repo->all());
    }

    public function testPuraListPaginate()
    {
        $repo = app(PuraRepository::class);
        Pura::factory(20)->create();

        $rs = $repo->list([
            'paginate' => '10',
            'current_page' => '1',
        ]);

        $this->assertCount(10 , $rs);
    }

    public function testPuraList()
    {
        $repo = app(PuraRepository::class);
        Pura::factory(20)->create();

        $rs = $repo->list();

        $this->assertCount(20 , $rs);
    }
}
