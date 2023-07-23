<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PuraNew extends Model
{
    use HasFactory;

    use HasFactory;

    protected $table = 'pura';

    public $timestamps = false;

    protected $fillable = [
        'nama_pura', 'lokasi', 'kabupaten'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'pura_users', 'pura_id', 'user_id')->withTimestamps();
    }

    public function detect()
    {
        return $this->hasMany(Detect::class, 'pura');
    }
}
