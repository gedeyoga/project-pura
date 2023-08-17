<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SensorPintuLog extends Model
{
    use HasFactory;

    protected $table = 'sensor_pintu_log';
    protected $fillable = [
        'sensor_pintu_id', 'status'
    ];

    public function sensor_pintu() 
    {
        return $this->belongsTo(SensorPintu::class , 'sensor_pintu_id');
    } 
}
