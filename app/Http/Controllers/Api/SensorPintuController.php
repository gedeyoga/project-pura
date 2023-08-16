<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AlertDeviceSensorPintuRequest;
use App\Http\Requests\CreateSensorPintuRequest;
use App\Http\Requests\UpdateSensorPintuRequest;
use App\Http\Resources\SensorPintuResource;
use App\Models\SensorPintu;
use App\Repositories\SensorPintuRepository;
use Illuminate\Http\Request;

class SensorPintuController extends Controller
{
    protected $sensor_pintu_repo;

    public function __construct()
    {
        $this->sensor_pintu_repo = app(SensorPintuRepository::class);
    }

    public function index(Request $request)
    {

        $puras = $this->sensor_pintu_repo->list($request->all());
        return SensorPintuResource::collection($puras);
    }

    public function store(CreateSensorPintuRequest $request)
    {
        $data = $request->all();

        $pura = $this->sensor_pintu_repo->create($data);

        return response()->json([
            'message' => 'Sensor pintu berhasil ditambahkan!',
            'data' => new SensorPintuResource($pura),
        ]);
    }

    public function show(SensorPintu $sensor_pintu)
    {
        $sensor_pintu->load(['pura']);
        return new SensorPintuResource($sensor_pintu);
    }

    public function update(SensorPintu $sensor_pintu, UpdateSensorPintuRequest $request)
    {
        $data = $request->all();

        $rs = $this->sensor_pintu_repo->update($sensor_pintu, $data);

        return response()->json([
            'message' => 'Sensor pintu berhasil diperbaharui!',
            'data' => new SensorPintuResource($rs),
        ]);
    }


    public function destroy(SensorPintu $sensor_pintu)
    {
        $this->sensor_pintu_repo->destroy($sensor_pintu);

        return response()->json([
            'message' => 'Sensor pintu berhasil dihapus',
        ]);
    }

    public function alertDevice(AlertDeviceSensorPintuRequest $request)
    {
        $sensor_pintu = $this->sensor_pintu_repo->getByCode($request->get('gs_kode_sensor'));

        if(is_null($sensor_pintu)) {
            return response()->json([
                'message' => 'Sensor Pintu tidak ditemukan',
            ] , 404);
        }

        $res = $this->sensor_pintu_repo->update($sensor_pintu , $request->all());

        return response()->json([
            'message' => 'Sensor Pintu berhasil disimpan.',
            'data' => new SensorPintuResource($res),
        ]);
    }
}
