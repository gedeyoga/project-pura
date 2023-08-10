<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateJenisPuraRequest;
use App\Http\Requests\UpdateJenisPuraRequest;
use App\Http\Resources\JenisPuraTransformer;
use App\Models\JenisPura;
use App\Repositories\JenisPuraRepository;
use Illuminate\Http\Request;

class JenisPuraController extends Controller
{
    protected $jenis_pura_repo;

    public function __construct() {
        $this->jenis_pura_repo = app(JenisPuraRepository::class);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $puras = $this->jenis_pura_repo->list($request->all());   
        return JenisPuraTransformer::collection($puras);

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateJenisPuraRequest $request)
    {
        $data = $request->all();

        $pura = $this->jenis_pura_repo->create($data);

        return response()->json([
            'message' => 'JenisPura berhasil ditambahkan!',
            'data' => new JenisPuraTransformer($pura),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\JenisPura  $pura
     * @return \Illuminate\Http\Response
     */
    public function show(JenisPura $jenis_pura)
    {
        return new JenisPuraTransformer($jenis_pura);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\JenisPura  $pura
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateJenisPuraRequest $request, JenisPura $jenis_pura)
    {
        $data = $request->all();

        $rs = $this->jenis_pura_repo->update($jenis_pura, $data);

        return response()->json([
            'message' => 'JenisPura berhasil diperbaharui!',
            'data' => new JenisPuraTransformer($jenis_pura),
        ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\JenisPura  $pura
     * @return \Illuminate\Http\Response
     */
    public function destroy(JenisPura $jenis_pura)
    {
        $this->jenis_pura_repo->destroy($jenis_pura);

        return response()->json([
            'message' => 'JenisPura berhasil dihapus',
        ]);
    }
}
