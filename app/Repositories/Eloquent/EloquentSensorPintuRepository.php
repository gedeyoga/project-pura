<?php

namespace App\Repositories\Eloquent;

use App\Events\SensorPintuActive;
use App\Events\SensorPintuNotActive;
use App\Repositories\SensorPintuRepository;

class EloquentSensorPintuRepository extends EloquentBaseRepository implements SensorPintuRepository
{
    public function list(array $params)
    {
        $sensor_pintus = $this->model

            ->when(isset($params['relations']), function ($q) use ($params) {
                $relations = explode(',', $params['relations']);
                return $q->with($relations);
            })

            //Pencarian berdasarkan index search 
            ->when(isset($params['search']), function ($q) use ($params) {
                return $q->where(function ($pura) use ($params) {
                    $pura->where('gs_kode_sensor', 'like', '%' . $params['search'] . '%')
                    ->orWhere('gs_nama', 'like', '%' . $params['search'] . '%');
                });
            })

            //Pencarian berdasarkan jenis pura
            ->when(isset($params['pura_id']), fn ($q) => $q->where('pura_id', $params['pura_id']))

            ->orderBy('id', 'desc')

            //Mengurutkan berdasarkan kolom order_by
            ->when(isset($params['order_by']) && isset($params['order']) && $params['order_by'] != '' && $params['order'] != '', function ($q) use ($params) {
                $q->orderBy($params['order_by'], $params['order']);
            });

        //jika tidak menerapkan pagination maka mereturn seluruh data
        if (!isset($params['paginate'])) {
            return $sensor_pintus->get();
        }

        //menerapkan pagination
        return $sensor_pintus->paginate(
            isset($data['per_page']) ? $data['per_page'] : 10,
            ['*'],
            'page',
            isset($data['current_page']) ? $data['current_page'] : null
        );
    }

    public function getByCode($code)
    {
        return $this->model->where('gs_kode_sensor' , $code)->first();
    }

    public function update($model, array $data)
    {
        $model->fill($data);
        $model->save();

        if(boolval($model->gs_sensor_pintu)) {
            event(new SensorPintuActive($model));
        }else {
            event(new SensorPintuNotActive($model));
        }

        return $model;
    }
}
