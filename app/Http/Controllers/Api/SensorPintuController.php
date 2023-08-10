<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AlertDeviceSensorPintuRequest;
use App\Http\Requests\CreateSensorPintuRequest;
use App\Http\Resources\SensorPintuResource;
use App\Repositories\SensorPintuRepository;
use Illuminate\Http\Request;

class SensorPintuController extends Controller
{
    protected $sensor_pintu_repo;

    public function __construct()
    {
        $this->sensor_pintu_repo = app(SensorPintuRepository::class);
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
