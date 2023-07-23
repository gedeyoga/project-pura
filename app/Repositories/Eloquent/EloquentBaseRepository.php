<?php 

namespace App\Repositories\Eloquent;

use App\Repositories\BaseRepository;

abstract class EloquentBaseRepository implements BaseRepository {

    protected $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($model, array $data)
    {
        $model->fill($data);
        $model->save();

        return $model;
    }

    public function destroy($model)
    {
        return $model->delete();
    }
}