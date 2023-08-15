<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateSensorCctvRequest;
use App\Http\Resources\SensorCctvResource;
use App\Repositories\SensorCctvRepository;
use App\Repositories\SensorPintuRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SensorCctvController extends Controller
{
    protected $sensor_cctv_repo, $sensor_pintu_repo;

    public function __construct()
    {
        $this->sensor_cctv_repo = app(SensorCctvRepository::class);
        $this->sensor_pintu_repo = app(SensorPintuRepository::class);
    }

    public function index(Request $request)
    {

        $puras = $this->sensor_cctv_repo->list($request->all());
        return SensorCctvResource::collection($puras);
    }

    public function store(CreateSensorCctvRequest $request)
    {
        $data = $request->all();

        $sensor_pintu = $this->sensor_pintu_repo->getByCode($request->get('gs_kode_sensor'));

        if(is_null($sensor_pintu)) {
            return response()->json([
                'message' => 'Tidak ada cctv dengan kode ' . $request->get('gs_kode_sensor'),
            ] , 404);
        }

        $data['pura_id'] = $sensor_pintu->id;

        $pura = $this->sensor_cctv_repo->create($data);

        return response()->json([
            'message' => 'Sensor Cctv berhasil ditambahkan!',
            'data' => new SensorCctvResource($pura),
        ]);
    }

    public function mostUsed(Request $request)
    {
        $most_sensor_cctv_active = $this->sensor_cctv_repo->getModel()
                                        ->select(['sensor_cctv.*', DB::raw('count(sensor_cctv.id) as jumlah_active')])
                                        ->with('pura')->where('cctv_status', 1)
                                        ->where('created_at', 'like', date('Y-m') . '%')
                                        ->groupBy(['gs_kode_sensor', 'pura_id'])
                                        ->orderBy('jumlah_active', 'desc')
                                        ->paginate($request->get('per_page'));

        return SensorCctvResource::collection($most_sensor_cctv_active);
    }
}
