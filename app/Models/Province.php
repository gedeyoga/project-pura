<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;

    protected $table = 'provinces';
    protected $fillable = [
        'id' , 'name'
    ];
    public $timestamps = false;

    public function regencies() 
    {
        return $this->hasMany(Regency::class , 'province_id');
    }
}
