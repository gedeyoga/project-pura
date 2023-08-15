<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SensorCctvResource;
use App\Http\Resources\SensorPintuResource;
use App\Repositories\PuraRepository;
use App\Repositories\SensorCctvRepository;
use App\Repositories\SensorPintuRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    protected $user_repo, $sensor_pintu_repo, $sensor_cctv_repo , $pura_repo;

    public function __construct()
    {
        $this->user_repo = app(UserRepository::class);
        $this->sensor_pintu_repo = app(SensorPintuRepository::class);
        $this->sensor_cctv_repo = app(SensorCctvRepository::class);
        $this->pura_repo = app(PuraRepository::class);
    }

    public function dashboardUser(Request $request)
    {
        $auth = $request->user();
        $pura = $auth->pura()->first();

        $user_count = $this->user_repo->getModel()->whereHas('pura' , function($q) use ($pura) {
            return $q->where('pura_id', $pura->id);
        })->count();

        $sensor_pintu_count = $this->sensor_pintu_repo->getModel()->where('pura_id' , $pura->id)->count();
        $sensor_cctvs = $this->sensor_cctv_repo->list([
            'per_page' => 5,
            'page' => 1,
            'paginate' => true,
            'pura_id' => $pura->id,
        ]);

        $sensor_pintus = $this->sensor_pintu_repo->list([
            'per_page' => 5,
            'page' => 1,
            'pura_id' => $pura->id,
            'paginate' => true,
        ]);

        return response()->json([
            'user_count' => $user_count,
            'sensor_pintu_count' => $sensor_pintu_count,
            'sensor_pintu_list' => SensorPintuResource::collection($sensor_pintus),
            'sensor_cctv_list' => SensorCctvResource::collection($sensor_cctvs),
        ]);
    }

    public function dashboardAdmin(Request $request) 
    {

        $user_count = $this->user_repo->all()->count();
        $sensor_pintu_count = $this->sensor_pintu_repo->all()->count();
        $pura_count = $this->pura_repo->all()->count();

        return response()->json([
            'user_count' => $user_count,
            'sensor_pintu_count' => $sensor_pintu_count,
            'pura_count' => $pura_count,
        ]);
    }
}
