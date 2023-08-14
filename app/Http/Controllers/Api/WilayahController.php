<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Province;
use App\Models\Regency;
use App\Models\Village;
use Illuminate\Http\Request;

class WilayahController extends Controller
{
    public function provinces(Request $request)
    {
        $data = Province::when(!is_null($request->get('name')), fn($q) => $q->where('name' , 'like', '%'.$request->get('name').'%'))
                        ->get();
        return response()->json($data);
    }

    public function regencies(Request $request)
    {
        $data = Regency::when(!is_null($request->get('name')), fn ($q) => $q->where('name', 'like', '%' . $request->get('name') . '%'))
                ->where('province_id' , $request->get('province_id'))
                ->get();
        return response()->json($data);
    }

    public function districts(Request $request)
    {
        $data = District::when(!is_null($request->get('name')), fn ($q) => $q->where('name', 'like', '%' . $request->get('name') . '%'))
                ->where('regency_id' , $request->get('regency_id'))
                ->get();
        return response()->json($data);
    }

    public function villages(Request $request)
    {
        $data = Village::when(!is_null($request->get('name')), fn ($q) => $q->where('name', 'like', '%' . $request->get('name') . '%'))
                ->where('district_id' , $request->get('district_id'))
                ->get();

        return response()->json($data);
    }
}
