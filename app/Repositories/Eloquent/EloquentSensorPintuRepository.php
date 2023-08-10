<?php

namespace App\Repositories\Eloquent;

use App\Events\SensorPintuActive;
use App\Events\SensorPintuNotActive;
use App\Repositories\SensorPintuRepository;

class EloquentSensorPintuRepository extends EloquentBaseRepository implements SensorPintuRepository
{

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
