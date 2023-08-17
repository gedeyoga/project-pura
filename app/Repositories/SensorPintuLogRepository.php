<?php 

namespace App\Repositories;

use App\Models\User;

interface SensorPintuLogRepository {
    
    public function list(array $params);
    public function create(array $data);
    
}