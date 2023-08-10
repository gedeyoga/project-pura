<?php 

namespace App\Repositories;

use App\Models\User;
use Illuminate\Http\Request;

interface RoleRepository {
    
    public function listRole(Request $request);
    
}