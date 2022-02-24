<?php


namespace Optimait\Laravel\Traits;


use Illuminate\Support\Facades\Auth;

trait CreaterUpdaterTrait {

    public static function bootCreaterUpdaterTrait(){
        /*if the table has user_id just set it to current id*/
        static::creating(function($model){
            /*$model->user_id = \Auth::id();*/
            $model->created_by = \Auth::id() ? \Auth::id() : 0;

        });
        /*if the table has user_id just set it to current id*/
        static::updating(function($model){
            $model->updated_by = \Auth::id() ? \Auth::id() : 0;
            /*$model->user_id = \Auth::id();*/

        });
    }


    public function creator(){
        return $this->belongsTo('App\User', 'created_by');
    }

    public function updater(){
        return $this->belongsTo('App\User', 'updated_by');
    }


    public function scopeMine($query){
        return $query->where('created_by', '=', \Auth::id() ? \Auth::id() : 0);
    }

    public function scopeOthers($query, $id){
        return $query->where('created_by', '=', $id);
    }

    public function createdByMe(){
        return $this->created_by == \Auth::id() ? \Auth::id() : 0;
    }

    public function updatedByMe(){
        return $this->updated_by == \Auth::id() ? \Auth::id() : 0;
    }

    public function createdByUser($id){
        return $this->created_by == $id;
    }

    public function updatedByUser($id){
        return $this->updated_by == $id;
    }
} 