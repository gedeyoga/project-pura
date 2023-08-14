<?php

namespace App\Repositories\Eloquent;

use App\Events\SensorCctvActive;
use App\Events\SensorCctvNotActive;
use App\Events\SensorPintuActive;
use App\Events\SensorPintuNotActive;
use App\Repositories\SensorCctvRepository;

class EloquentSensorCctvRepository extends EloquentBaseRepository implements SensorCctvRepository
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
                    $pura->where('gs_kode_sensor', 'like', '%' . $params['search'] . '%');
                });
            })

            //Pencarian berdasarkan jenis pura
            ->when(isset($params['pura_id']), fn ($q) => $q->where('pura_id', $params['pura_id']))
            ->when(isset($params['cctv_status']), fn ($q) => $q->whereIn('cctv_status', $params['cctv_status']))

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

    public function create($data)
    {
        $data = $this->model->create($data);

        if(boolval($data->cctv_status)) {
            event(new SensorCctvActive($data));
        }else {
            event(new SensorCctvNotActive($data));
        }

        return $data;
    }
}
