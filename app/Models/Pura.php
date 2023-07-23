<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pura extends Model
{
    use HasFactory;

    protected $table = 'pura';

    protected $fillable = [
        'pura_nama' , 'pura_alamat' , 'pura_lat' , 'pura_lng', 'jp_id' , 'kel_id' , 'pura_ip', 'pura_sensor_cctv'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'pura_users', 'pura_id', 'user_id')->withTimestamps();
    }

    public function detect() 
    {
        return $this->hasMany(Detect::class , 'pura');
    }

    
}
