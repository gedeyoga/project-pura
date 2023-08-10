<?php 

namespace App\Repositories;

use App\Models\Pura;

interface PuraRepository {
    public function list(array $params = []);
    
    public function createPura(array $data);
    
    public function updatePura(Pura $pura, array $data);

    public function deletePura(Pura $pura);

    public function uploadFotoPura(Pura $pura , array $data = []);
    
}