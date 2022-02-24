<?php
/**
 * Created by PhpStorm.
 * User: monkeyDluffy
 * Date: 2/9/2016
 * Time: 1:03 AM
 */

namespace Optimait\Laravel\Traits;


trait StatusTrait
{

    public function scopeActive($query){
        return $query->where('status', '=', 1);
    }

    public function scopeInActive($query){
        return $query->where('status', '=', 0);
    }

    public function isActive(){
        return $this->status == 1;
    }

    public static $statusLabel = [
        0 => '<label class="btn btn-danger btn-sm">Inactive</label>',
        1 => '<label class="btn btn-success btn-sm">Active</label>',
    ];

}