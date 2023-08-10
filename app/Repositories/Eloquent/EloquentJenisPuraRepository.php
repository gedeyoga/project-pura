<?php

namespace App\Repositories\Eloquent;

use App\Models\Pura;
use App\Repositories\JenisPuraRepository;

class EloquentJenisPuraRepository extends EloquentBaseRepository implements JenisPuraRepository
{
    public function list(array $params)
    {
        $jenis_puras = $this->model

            //Pencarian berdasarkan index search 
            ->when(isset($params['search']), function ($q) use ($params) {
                return $q->where('jp_nama', 'like', '%' . $params['search'] . '%');
            })

            //Pencarian berdasarkan active dan tidak active
            ->when(isset($params['jp_active']), fn ($q) => $q->where('jp_active', $params['jp_active']));

        //jika tidak menerapkan pagination maka mereturn seluruh data
        if (!isset($params['paginate'])) {
            return $jenis_puras->get();
        }

        //menerapkan pagination
        return $jenis_puras->paginate(
            isset($data['per_page']) ? $data['per_page'] : 10,
            ['*'],
            'page',
            isset($data['current_page']) ? $data['current_page'] : null
        );
    }
}
