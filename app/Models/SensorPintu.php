<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Alfa6661\AutoNumber\AutoNumberTrait;

class SensorPintu extends Model
{
    use HasFactory , AutoNumberTrait;

    protected $table = 'sensor_pintu';

    protected $fillable = [
        'gs_nama' , 'gs_sensor_pintu' , 'pura_id', 'gs_kode_sensor' , 'guard_state' , 'token',
    ];

    public function getAutoNumberOptions()
    {
        return [
            'gs_kode_sensor' => [
                'format' => function () {
                    return 'GS' . date('Ymd') .'?'; 
                },
                'length' => 4,
            ]
        ];
    }

    public function pura()
    {
        return $this->belongsTo(Pura::class , 'pura_id');
    }
}
