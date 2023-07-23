<?php 

namespace App\Repositories;

use App\Models\User;

interface UserRepository {
    public function createUser(array $data);
    
    public function updateUser(User $user, array $data);

    public function deleteUser(User $user);
    
}