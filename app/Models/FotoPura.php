<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FotoPura extends Model
{
    use HasFactory;

    protected $table = 'foto_pura';

    protected $fillable = [
        'fp_url', 'fp_keterangan' , 'pura_id',
    ];

    public function pura()
    {
        return $this->belongsTo(Pura::class , 'pura_id');
    }
}
