<?php
namespace Optimait\Laravel\Validators;


use Optimait\Laravel\Services\Validation\Laravel\LaravelValidator;
use Optimait\Laravel\Services\Validation\ValidationService;

class MediaValidator extends LaravelValidator implements ValidationService {



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