<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    public function getFillable()
    {
        return $this->fillable;
    }
    public function fetchList($map, $pageSize=30)
    {
        return $this->where($map)->paginate($pageSize);
    }

    public function updateItem($data, $id)
    {
        $model = $this->find($id);
        if (empty($model))
            return false;

        foreach ($data as $k => $v)
        {
            $model->$k = $v;
        }

        if ($model->save())
            return $model;
        else
            return false;
    }

    public function createOne($data)
    {
        foreach ($data as $k => $v)
            $this->$k = $v;

        return $this->save();
    }
}
