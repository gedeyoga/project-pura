<?php 

namespace App\Repositories;

use App\Models\User;

interface SensorPintuRepository {
    
    public function list(array $params);
    public function getByCode($code);
    
}