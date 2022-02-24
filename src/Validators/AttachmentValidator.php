<?php
/**
 * Created by PhpStorm.
 * User: Zorro
 * Date: 5/30/2016
 * Time: 1:14 PM
 */

namespace Optimait\Laravel\Validators;


use Optimait\Laravel\Services\Validation\Laravel\LaravelValidator;
use Optimait\Laravel\Services\Validation\ValidationService;

class AttachmentValidator extends LaravelValidator implements ValidationService {



    /**
     * Validation for creating a new User
     *
     * @var array
     */
    protected $rules = array(
        'default'=>array(
            'name' => 'required',
        ),


    );

}