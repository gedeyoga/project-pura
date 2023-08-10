<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RoleTransformer;
use App\Models\Role;
use App\Repositories\RoleRepository;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{

    protected $role_repo; 

    public function __construct()
    {
        $this->role_repo = app(RoleRepository::class);
    }

    public function index(Request $request)
    {
        $roles = $this->role_repo->listRole($request);

        return RoleTransformer::collection($roles);
    }

    public function permissionStore(Request $request)
    {
        $permission = Permission::create([
            'name' => $request->get('name')
        ]);

        $module = explode('.' , $permission->name);
        $module = $module[0];


        return response()->json([
            'message' => 'Berhasil membuat permission!',
            'data' => [
                'module' => $module,
                'name' => $permission->name,
                'allow' => false,
            ],
        ]);
    }

    public function permissionList(Request $request)
    {
        $permission = Permission::all();
        $permission = $permission->map(function($item) {
            $group_name = explode('.' , $item->name);
            return [
                'module' => $group_name[0],
                'name' => $item->name,
                'allow' => false,
            ];
        })->groupBy('module');

        return $permission;
    }

    public function show(Role $role) 
    {
        $role->load('permissions');

        return new RoleTransformer($role);
    }

    public function store(Request $request)
    {
        $list_permissions = $request->get('permissions');

        $allow_permissions = [];
        foreach ($list_permissions as $module => $permissions) {
            foreach ($permissions as $item) {
                if($item['allow']) {
                    array_push($allow_permissions , $item['name']);
                }
            }
        }

        $role = Role::create(['name' => $request->get('name')]);
        $permissions = Permission::whereIn('name' , $allow_permissions)->get();

        $role->syncPermissions($permissions);

        return response()->json([
            'message' => 'Berhasil menambahkan role!'
        ]);

    }

    public function update(Request $request , Role $role)
    {
        $list_permissions = $request->get('permissions');

        $allow_permissions = [];
        foreach ($list_permissions as $module => $permissions) {
            foreach ($permissions as $item) {
                if ($item['allow']) {
                    array_push($allow_permissions, $item['name']);
                }
            }
        }

        $role->update(['name' => $request->get('name')]);

        $permissions = Permission::whereIn('name', $allow_permissions)->get();
        $role->syncPermissions($permissions);

        return response()->json([
            'message' => 'Berhasil menyimpan role!'
        ]);
    }

    public function destroy(Role $role)
    {
        $role->delete();

        return response()->json([
            'message' => 'Berhasil menghapus Role'
        ]);
    }
}
