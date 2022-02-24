<?php
namespace Optimait\Laravel\Repos;

use Illuminate\Database\Eloquent\Model;
use Optimait\Laravel\Exceptions\ApplicationException;
use Optimait\Laravel\Exceptions\EntityNotFoundException;
use Optimait\Laravel\Repos\Contracts\BaseRepositoryInterface;

abstract class EloquentRepository implements BaseRepositoryInterface
{
    protected $model;
    protected $attrToValidate;
    protected $attrToSave;

    /**
     * @param mixed $attrToSave
     */
    public function setAttrToSave($attrToSave)
    {
        $this->attrToSave = $attrToSave;
    }

    /**
     * @return mixed
     */
    public function getAttrToSave()
    {
        return $this->attrToSave;
    }

    /**
     * @param mixed $attrToValidate
     */
    public function setAttrToValidate($attrToValidate)
    {
        $this->attrToValidate = $attrToValidate;
    }

    /**
     * @return mixed
     */
    public function getAttrToValidate()
    {
        return $this->attrToValidate;
    }

    public function __construct($model = null)
    {
        $this->model = $model;
    }

    public function getModel()
    {
        return $this->model;
    }

    public function setModel($model)
    {
        $this->model = $model;
    }

    public function getAll($with = false)
    {
        if ($with) {
            return $this->model->with($with)->get();
        }
        return $this->model->all();
    }

    public function getAllPaginated($count)
    {
        return $this->model->paginate($count);
    }

    public function getById($id)
    {
        return $this->model->find($id);
    }

    public function requireById($id)
    {
        $model = $this->getById($id);

        if (!$model) {
            throw new EntityNotFoundException("Entity Not Found");
        }

        return $model;
    }

    public function getNew($attributes = array())
    {
        return $this->model->newInstance($attributes);
    }

    public function save($data)
    {
        if ($data instanceOf Model) {
            return $this->storeEloquentModel($data);
        } elseif (is_array($data)) {
            return $this->storeArray($data);
        }
    }

    public function delete($model)
    {
        return $model->delete();
    }

    public function storeEloquentModel($model)
    {
        if ($model->getDirty()) {
            return $model->save();
        } else {
            return $model->touch();
        }
    }

    public function storeArray($data)
    {
        $model = $this->getNew($data);
        return $this->storeEloquentModel($model);
    }

    public function startTransaction()
    {
        \Illuminate\Support\Facades\DB::beginTransaction();
    }

    public function commitTransaction()
    {
        \Illuminate\Support\Facades\DB::commit();
    }

    public function rollbackTransaction()
    {
        \Illuminate\Support\Facades\DB::rollBack();
    }

    public function findOneBy($filter=[], $callback = null){
        $q = $this->model->whereRaw("1 = 1");
        foreach($filter as $k => $v){
            $q->where($k, $v);
        }
        if(!is_null($callback) && is_callable($callback)){
            $callback($q);
        }
        return $q->first();
    }

    public function findBy($filter=[], $callback = null){
        $q = $this->model->whereRaw("1 = 1");
        foreach($filter as $k => $v){
            $q->where($k, $v);
        }
        if(!is_null($callback) && is_callable($callback)){
            $callback($q);
        }
        return $q->get();
    }


    public function checkDuplicates($filter=[], $id = [])
    {
        $q = $this->model->whereRaw("1 = 1");
        foreach($filter as $k => $v){
            $q->where($k, $v);
        }
        //echo $email;
        if ($q->whereNotIn('id', $id)->count()) {
            throw new ApplicationException('Duplicate Found');
        }
        //print_r(\DB::getQueryLog());
    }
}
