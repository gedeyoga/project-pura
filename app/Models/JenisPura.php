<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisPura extends Model
{
    use HasFactory;

    protected $table = 'jenis_pura';

    protected $fillable = [
        'jp_nama' , 'jp_active',
    ];
}
