<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\RoleRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class EloquentRoleRepository extends EloquentBaseRepository implements RoleRepository
{

    public function listRole(Request $request)
    {
        $roles = $this->model;

        if($request->get('search')) {
            $roles = $roles->where(function($query) use ($request) {
                $query->where('name' , 'like' , '%'.$request->get('search').'%');
            });
        }

        if($request->get('type') == 'all') {
            $roles = $roles->get();
        }else{
            $roles = $roles->paginate($request->get('per_page', 10));
        }

        return $roles;
    }
    
}
