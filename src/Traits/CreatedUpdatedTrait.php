<?php
/**
 * Created by PhpStorm.
 * User: monkeyDluffy
 * Date: 10/28/2015
 * Time: 1:59 PM
 */

namespace Optimait\Laravel\Traits;


trait CreatedUpdatedTrait
{
    public function createdDate($format = "Y-m-d"){
        return date($format, strtotime($this->created_at));
    }


    public function createdTime($format = "H:i:s"){
        return date($format, strtotime($this->created_at));
    }

    public function createdDateTime($format = "Y-m-d H:i:s"){
        return date($format, strtotime($this->created_at));
    }
}