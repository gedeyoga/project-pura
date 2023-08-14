<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SensorCctv extends Model
{
    use HasFactory;

    protected $table = 'sensor_cctv';

    protected $fillable = [
        'cctv_photo', 'cctv_status', 'pura_id', 'gs_kode_sensor',
    ];

    public function pura()
    {
        return $this->belongsTo(Pura::class , 'pura_id');
    }
}
