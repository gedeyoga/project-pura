<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserTransformer;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class UserController extends Controller
{

    protected $user_repo;

    public function __construct()
    {
        $this->user_repo = app(UserRepository::class);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = $this->user_repo->listUser($request);
        return UserTransformer::collection($users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUserRequest $request)
    {
        $data = $request->all();
        if(!isset($data['role'])) {
            $data['role'] = 'user';
        }
        $user = $this->user_repo->createUser($data);

        if($request->get('pura_id')) {
            $user->pura()->attach($request->get('pura_id'));
        }

        return response()->json([
            'message' => 'Tambah data user berhasil!',
            'data' => new UserTransformer($user)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $user->load('roles', 'pura');
        return new UserTransformer($user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $data = $request->except(['password']);

        if (!isset($data['role'])) {
            $data['role'] = 'user';
        }
        
        if ($request->get('change_password')) {
            $data['password'] = bcrypt($request->get('password'));
        }

        $user = $this->user_repo->updateUser($user, $data);

        $user->pura()->detach();
        if ($request->get('has_pura')) {
            $user->pura()->attach($request->get('pura_id'));
        }

        return response()->json([
            'message' => 'Berhasil memperbaharui data user!',
            'data' => new UserTransformer($user),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $this->user_repo->deleteUser($user);

        return response()->json([
            'message' => 'Berhasil menghapus data user!',
        ]);
    }
}
