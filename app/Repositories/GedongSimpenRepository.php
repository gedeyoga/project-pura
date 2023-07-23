<?php 

namespace App\Repositories;

use App\Models\User;

interface GedongSimpenRepository {
    
    public function getByCode($code);
    
}