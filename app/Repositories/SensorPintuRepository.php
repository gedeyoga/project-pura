<?php 

namespace App\Repositories;

use App\Models\User;

interface SensorPintuRepository {
    
    public function getByCode($code);
    
}