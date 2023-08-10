<?php

namespace App\Http\Controllers;

use App\Models\SensorPintu;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
    public function notif(Request $request)
    {
        $sensor_pintu = SensorPintu::find($request->get('id'));
        return view('notif' , [
            'sensor' => $sensor_pintu,
            'gambar' => $sensor_pintu->pura->detect()->orderByDesc('id')->first(),
        ]);
    }
}
