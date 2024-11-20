<?php

namespace App\Repositories;

use App\Models\Resource;
use Illuminate\Database\Eloquent\Model;

class BaseRepository {

    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * @return The `all()` method is returning all records from the model using the `get()` method.
     */
    public function all()
    {
        return $this->model::get();
    }

    /**
     * @return The `delete()` method is being called on the `` object, which will delete the
     * corresponding record from the database. The return value of the `delete()` method is being returned
     * from the `delete()` function.
     */
    public function delete(Model $model)
    {
        return $model->delete();
    }

}
