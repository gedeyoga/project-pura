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
        if($request->get('code')) {
            return $this->code($request);
        }

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

    public function code(Request $request) 
    {
        if(is_null($request->get('code'))) {
            return response()->json([
                'message' => 'Data tidak ditemukan'
            ] , 404);
        }

        $data = $this->sensor_pintu_repo->getByCode($request->get('code'));

        if(is_null($data)) {
            return response()->json([
                'message' => 'Data tidak ditemukan'
            ] , 404);
        }

        $data->load(['pura']);
        return new SensorPintuResource($data);
    }

    public function ping(Request $request)
    {
        if (is_null($request->get('code'))) {
            return response()->json([
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        $data = $this->sensor_pintu_repo->getByCode($request->get('code'));
    

        if (is_null($data)) {
            return response()->json([
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        $phones = $data->pura->users->map(function ($item) {
            $arr = explode(' ', $item->phone);
            $phone = implode('', $arr);
            return $item->phone ? $phone : '0';
        })->toArray();

        $sensor = $this->sensor_pintu_repo->update($data, [
            'ping_at' => date('Y-m-d H:i:s'),
            'gs_sensor_pintu' => $request->get('status' , 0),
        ]);

        $sensor = $sensor->setRelations([]);

        return response()->json([
            'message' => 'Ping berhasil',
            'data' => new SensorPintuResource($sensor),
            'phones' => $phones,
        ]);
    }
}
