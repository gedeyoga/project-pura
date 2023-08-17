<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateSensorPintuLogRequest;
use App\Http\Resources\SensorPintuLogResource;
use App\Repositories\SensorPintuLogRepository;
use App\Repositories\SensorPintuRepository;
use Illuminate\Http\Request;

class SensorPintuLogController extends Controller
{

    protected $repo;

    public function __construct()
    {
        $this->repo = app(SensorPintuLogRepository::class);    
    }

    public function index(Request $request) 
    {
        $data = $this->repo->list($request->all());

        return SensorPintuLogResource::collection($data);
    }

    public function store(CreateSensorPintuLogRequest $request)
    {
        $sensor_pintu_repo = app(SensorPintuRepository::class);

        $sensor_pintu = $sensor_pintu_repo->getByCode($request->get('code'));
        
        if(is_null($sensor_pintu)) {
            return response()->json([
                'message' => 'Sensor tidak ditemukan'
            ], 404);
        }

        $data = $this->repo->create([
            'sensor_pintu_id' => $sensor_pintu->id,
            'status' => $request->get('status'),
        ]);

        return response()->json([
            'message' => 'Sensor berhasil ' . (boolval($data->status) ? 'Dibuka' : 'Ditutup'), 
        ]);
    }
}
