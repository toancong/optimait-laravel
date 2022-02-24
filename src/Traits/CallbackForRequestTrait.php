<?php
/**
 * Created by PhpStorm.
 * User: Zorro
 * Date: 3/29/2016
 * Time: 3:11 PM
 */

namespace Optimait\Laravel\Traits;


use Closure;

trait CallbackForRequestTrait
{
    public function processCallbackForRequest(Closure $c = null){
        if(!is_null($c) && is_callable($c)){
            return $c($this);
        }
        else{
            return array();
        }
    }
}