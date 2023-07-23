<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AlertDeviceGedongSimpenRequest;
use App\Http\Requests\CreateGedongSimpenRequest;
use App\Http\Resources\GedongSimpenResource;
use App\Repositories\GedongSimpenRepository;
use Illuminate\Http\Request;

class GedongSimpenController extends Controller
{
    protected $gedong_repo;

    public function __construct()
    {
    $this->gedong_repo = app(GedongSimpenRepository::class);
    }

    public function alertDevice(AlertDeviceGedongSimpenRequest $request)
    {
        $gedong_simpen = $this->gedong_repo->getByCode($request->get('gs_kode_sensor'));

        if(is_null($gedong_simpen)) {
            return response()->json([
                'message' => 'Gedong tidak ditemukan',
            ] , 404);
        }

        $res = $this->gedong_repo->update($gedong_simpen , $request->all());

        return response()->json([
            'message' => 'Gedong berhasil disimpan.',
            'data' => new GedongSimpenResource($res),
        ]);
    }
}
