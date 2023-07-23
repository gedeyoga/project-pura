<?php

namespace App\Repositories\Eloquent;

use App\Events\SensorGedongActive;
use App\Events\SensorGedongNotActive;
use App\Repositories\GedongSimpenRepository;

class EloquentGedongSimpenRepository extends EloquentBaseRepository implements GedongSimpenRepository
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
            event(new SensorGedongActive($model));
        }else {
            event(new SensorGedongNotActive($model));
        }

        return $model;
    }
}
