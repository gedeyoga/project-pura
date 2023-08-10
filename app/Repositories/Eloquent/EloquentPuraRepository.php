<?php

namespace App\Repositories\Eloquent;

use App\Models\Pura;
use App\Repositories\PuraRepository;

class EloquentPuraRepository extends EloquentBaseRepository implements PuraRepository
{

    public function list(array $params = [])
    {
        $puras = $this->model
 
        ->when(isset($params['relations']), function($q) use ($params) {
            $relations = explode(',' , $params['relations']);
            return $q->with($relations);
        })

        //Pencarian berdasarkan index search 
        ->when(isset($params['search']) , function($q) use ($params) {
            return $q->where(function($pura) use ($params) {
                $pura->where('pura_nama' , 'like' , '%'.$params['search'].'%')
                ->orWhere('pura_alamat' , 'like' , '%'.$params['search'].'%')
                ->orWhere('pura_ip' , 'like' , '%'.$params['search'].'%');
            });
        })

        //Pencarian berdasarkan jenis pura
        ->when(isset($params['jp_id']), fn($q) => $q->where('jp_id' , $params['jp_id']))

        //Mengurutkan berdasarkan kolom order_by
        ->when(isset($params['order_by']) && isset($params['order']) && $params['order_by'] != '' && $params['order'] != '' , function($q) use ($params) {
            $q->orderBy($params['order_by'], $params['order']);
        });

        //jika tidak menerapkan pagination maka mereturn seluruh data
        if(!isset($params['paginate'])) {
            return $puras->get();
        }

        //menerapkan pagination
        return $puras->paginate(
            isset($data['per_page']) ? $data['per_page'] : 10,
            ['*'],
            'page',
            isset($data['current_page']) ? $data['current_page'] : null
        );

    }

    public function createPura(array $data)
    {
        $pura = $this->create($data);
        if (isset($data['foto_puras'])) {
            $this->uploadFotoPura($pura, $data['foto_puras']);
        }

        return $pura;
    }

    public function updatePura(Pura $pura, array $data)
    {
        $pura = $this->update($pura , $data);

        if(isset($data['foto_puras'])) {
            $this->uploadFotoPura($pura , $data['foto_puras']);
        }

        return $pura;
    }

    public function deletePura(Pura $pura)
    {
        return $this->destroy($pura);
    }

    public function uploadFotoPura(Pura $pura , $data = [])
    {    
        $pura->foto_pura()->delete();
        return $pura->foto_pura()->createMany($data);
    }
    
}
