<?php 

namespace App\Repositories;

use App\Models\User;

interface SensorCctvRepository {
    
    public function list(array $params); 
    
}