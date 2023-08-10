<?php

namespace Tests\Feature;

use App\Models\JenisPura;
use App\Repositories\JenisPuraRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class JenisPuraRepositoryTest extends TestCase
{
    public function testCreateJenisPura()
    {
        $repo = app(JenisPuraRepository::class);
        $data = JenisPura::factory()->make()->toArray();

        $rs = $repo->create($data);

        $this->assertEquals($data['jp_nama'], $rs->jp_nama);
    }

    public function testUpdateJenisPura()
    {
        $this->testCreateJenisPura();

        $repo = app(JenisPuraRepository::class);
        $jp = JenisPura::first();

        $rs = $repo->update($jp, [
            'jp_nama' => 'Pura Melanting'
        ]);

        $this->assertEquals('Pura Melanting', $rs->jp_nama);
    }

    public function testDeleteJenisPura()
    {
        $this->testUpdateJenisPura();
        $repo = app(JenisPuraRepository::class);
        $pura = JenisPura::first();

        $repo->destroy($pura);

        $this->assertCount(0, $repo->all());
    }
}
