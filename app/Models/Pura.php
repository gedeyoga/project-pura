<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pura extends Model
{
    use HasFactory;

    protected $table = 'pura';

    protected $fillable = [
        'pura_nama' , 'pura_alamat' , 'pura_lat' , 'pura_lng', 'jp_id' , 'kel_id' , 'pura_ip',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'pura_users', 'pura_id', 'user_id')->withTimestamps();
    }

    public function detect() 
    {
        return $this->hasMany(Detect::class , 'pura');
    }

    public function foto_pura()
    {
        return $this->hasMany(FotoPura::class , 'pura_id');
    }

    public function jenis_pura()
    {
        return $this->belongsTo(JenisPura::class , 'jp_id');
    }

    
}
