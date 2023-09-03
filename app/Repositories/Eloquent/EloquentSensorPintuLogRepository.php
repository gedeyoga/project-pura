<?php

namespace App\Repositories\Eloquent;

use App\Events\SensorPintuActive;
use App\Events\SensorPintuClosed;
use App\Events\SensorPintuNotActive;
use App\Events\SensorPintuOpen;
use App\Events\SensorPintuTerbuka;
use App\Repositories\SensorPintuLogRepository;

class EloquentSensorPintuLogRepository extends EloquentBaseRepository implements SensorPintuLogRepository
{
    public function list(array $params)
    {
        $sensor_pintus = $this->model

            ->when(isset($params['relations']), function ($q) use ($params) {
                $relations = explode(',', $params['relations']);
                return $q->with($relations);
            })

            //Pencarian berdasarkan date
            ->when(isset($params['date']), function ($q) use ($params) {
                return $q->whereBetween('created_at' , [
                    date('Y-m-d 00:00' , strtotime($params['date'][0])),
                    date('Y-m-d 23:59' , strtotime($params['date'][1])),
                ]);
            })

            ->when(isset($params['status']), function ($q) use ($params) {
                return $q->whereIn('status' , $params['status']);
            })

            //Pencarian berdasarkan jenis pura

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

    public function create(array $data)
    {
        $sensor_log = $this->model->create($data);

        if(boolval($sensor_log->status)) {
            event(new SensorPintuOpen($sensor_log));
        }else {
            event(new SensorPintuClosed());
        }

        return $sensor_log;
    }

    
}
