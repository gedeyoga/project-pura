<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detect extends Model
{
    use HasFactory;

    protected $table = 'detect';

    public $timestamps = false;

    protected $fillable = [
        'pura', 'tanggal', 'waktu', 'path_image',
    ];

    public function pura()
    {
        return $this->belongsTo(PuraNew::class , 'pura');
    }
}
