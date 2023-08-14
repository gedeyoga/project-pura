<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Regency extends Model
{
    use HasFactory;

    protected $table = 'regencies';
    protected $fillable = ['id','province_id', 'name'];
    public $timestamps = false;

    public function districts()
    {
        return $this->hasMany(District::class , 'regency_id');
    }

    public function province()
    {
        return $this->belongsTo(Province::class , 'province_id');
    }

}
