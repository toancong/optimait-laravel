<?php

namespace Optimait\Laravel\Services\Validation\Laravel;


use Optimait\Laravel\Exceptions\ValidationException;
use Illuminate\Validation\Factory;
use Optimait\Laravel\Services\Validation\AbstractValidator;

class LaravelValidator extends AbstractValidator {



    /**
     * Construct
     *
     * @param Illuminate\Validation\Factory;
     */
    public function __construct(Factory $validator)
    {
        $this->validator = $validator;
    }


    /**
     * Pass the data and the rules to the validator
     *
     * @return boolean
     */
    function isValid($throwException = true)
    {
        $validator = $this->validator->make($this->data, $this->rules[$this->defaultRule], $this->messages);

        if( $validator->fails() )
        {
            $this->errors = $validator->messages();

            if($throwException){
                throw new ValidationException('Validation Error', $this->errors);
            }
            return false;
        }

        return true;
    }

}