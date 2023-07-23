<?php 

namespace App\Repositories;

interface BaseRepository {
    
    public function find($id);
    public function create(array $data);
    public function update($model , array $data);
    public function destroy($model);
    
}

