<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageLog extends Model
{
    use HasFactory;

    protected $table = 'message_logs';
    protected $fillable = [
        'modelable_id', 'modelable_type','phone' , 'message'
    ];

    public function model()
    {
        return $this->morphTo('modelable');
    }
    
    

}
