<?php

namespace App\Repositories\Eloquent;

use App\Events\UserWasCreated;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class EloquentUserRepository extends EloquentBaseRepository implements UserRepository
{

    public function listUser(Request $request)
    {
        $users = $this->model;


        if($request->get('relations')) {
            $relations = explode(',', $request->get('relations'));
            $users = $users->with($relations);
        }

        if($request->get('search')) {
            $users = $users->where(function($query) use ($request) {
                $query->where('name' , 'like' , '%'.$request->get('search').'%')
                ->orWhereHas('roles' , fn ($query) => $query->where('roles.name' , 'like' , '%' . $request->get('search') . '%' ));
            });
        }

        if($request->get('roles')){

            $roles = explode(',' , $request->get('roles'));
            $users = $users->whereHas('roles' , function($query) use ($roles) {
                $query->whereIn('name' ,  $roles)
                ->whereNotIn('name' , ['customer']);
            });
        }

        if($request->get('pura_id')){

            $users = $users->whereHas('pura' , function($query) use ($request) {
                $query->where('id' ,  $request->get('pura_id'));
            });
            
        }

        return $users->paginate($request->get('per_page' , 10));
    }

    public function createUser(array $data)
    {
        $data['password'] = bcrypt($data['password']);
        $user = $this->model->create($data);

        $this->createUserToken($user , 'auth_token');

        if(isset($data['role'])) {
            $user->assignRole($data['role']);
        }

        event(new UserWasCreated());

        return $user;

    }

    public function createUserToken(User $user , $token_name)
    {
        $token = $user->createToken($token_name)->plainTextToken;

        return $token;
    }

    public function updateUser(User $user , array $data)
    {
        $user->fill($data);
        $user->save();

        if(isset($data['role'])) {
            $user->syncRoles($data['role']);
        }

        return $user;
    }

    public function deleteUser(User $user)
    {
        $user->roles()->detach();
        
        return  $user->delete();
    }

    public function listCustomer(Request $request)
    {
        $users = $this->model;

        if ($request->get('relations')) {
            $relations = explode(',', $request->get('relations'));
            $users = $users->with($relations);
        }

        if ($request->get('search')) {
            $users = $users->where(function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->get('search') . '%');
            });
        }

        $users = $users->whereHas('roles', function ($query) {
            $query->whereIn('name',  ['customer']);
        });

        return $users->orderBy('created_at' , 'desc')->paginate($request->get('per_page', 10));
    }
    
}
