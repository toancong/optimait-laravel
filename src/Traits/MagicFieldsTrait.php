<?php
/**
 * Created by PhpStorm.
 * User: monkeyDluffy
 * Date: 2/2/2016
 * Time: 6:48 PM
 */

namespace Optimait\Laravel\Traits;


trait MagicFieldsTrait
{
    private $_attributes = array();

    public function __get($name){
        return isset($this->_attributes[$name]) ? $this->_attributes[$name] : null;
    }

    public function __set($name, $value){
        $this->_attributes[$name] = $value;
    }

    public function getOriginal(){
        return $this->_attributes;
    }


}