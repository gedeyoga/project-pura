<?php 

namespace App\Repositories;

use App\Models\Pura;

interface JenisPuraRepository {
    public function list(array $params);
}