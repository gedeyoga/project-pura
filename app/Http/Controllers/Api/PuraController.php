<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreatePuraRequest;
use App\Http\Requests\UpdatePuraRequest;
use App\Http\Resources\PuraTransformer;
use App\Models\Pura;
use App\Repositories\PuraRepository;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

use function App\Helpers\uploadImage;

class PuraController extends Controller
{

    protected $pura_repo;

    public function __construct() {
        $this->pura_repo = app(PuraRepository::class);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $puras = $this->pura_repo->list($request->all());   
        return PuraTransformer::collection($puras);

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePuraRequest $request)
    {
        $data = $request->all();

        if(isset($data['foto_puras'])) {
            foreach ($data['foto_puras'] as $index =>  $foto) {
                if(isset($foto['file'])) {
                    if (!is_string($foto['file']) && !is_null($foto['file'])) {

                        $foto['fp_url'] = uploadImage($foto['file'] , 'upload');
                        unset($foto['file']);

                        $data['foto_puras'][$index] = $foto;
                    }
                }
            }
        }

        $pura = $this->pura_repo->createPura($data);

        return response()->json([
            'message' => 'Pura berhasil ditambahkan!',
            'data' => new PuraTransformer($pura),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pura  $pura
     * @return \Illuminate\Http\Response
     */
    public function show(Pura $pura)
    {
        $pura->load(['jenis_pura' , 'foto_pura']);
        return new PuraTransformer($pura);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pura  $pura
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePuraRequest $request, Pura $pura)
    {
        $data = $request->all();

        if (isset($data['foto_puras'])) {
            foreach ($data['foto_puras'] as $index => $foto) {
                if (isset($foto['file'])) {
                    if (!is_string($foto['file']) && !is_null($foto['file'])) {
                        $foto['fp_url'] = uploadImage($foto['file'], 'upload');
                        unset($foto['file']);

                        $data['foto_puras'][$index] = $foto;
                    }else {
                        $data['foto_puras'][$index]['fp_url'] = $foto['file'];
                    }
                }
            }
        }

        $rs = $this->pura_repo->updatePura($pura, $data);

        return response()->json([
            'message' => 'Pura berhasil diperbaharui!',
            'data' => new PuraTransformer($pura),
        ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pura  $pura
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pura $pura)
    {
        $this->pura_repo->destroy($pura);

        return response()->json([
            'message' => 'Pura berhasil dihapus',
        ]);
    }

    public function stateNotification(Request $request) 
    {
        $request->validate([
            'notification_type' => 'required|string',
            'status' => 'required|numeric',
        ]);

        $pura = $request->user()->pura()->first();

        if(!is_null($request->get('pura_id'))) {
            $pura = $this->pura_repo->find($request->get('pura_id'));
        }

        if (is_null($pura)) {
            return response()->json([
                'message' => 'Data pura tidak ditemukan',
            ], 404);
        }
                
        if($request->get('notification_type') == 'sensor_cctv') {
            $this->pura_repo->update($pura, [
                'notification_cctv' => $request->get('status'),
            ]);
        }

        return response()->json([
            'message' => 'Berhasil memperbaharui notifikasi!',
        ]);
    }
}
