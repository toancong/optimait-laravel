<?php

namespace Optimait\Laravel\Services\Validation;


abstract class AbstractValidator
{
    /**
     * Validator
     *
     * @var object
     */
    protected $validator;

    /**
     * Data to be validated
     *
     * @var array
     */
    protected $data = array();

    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = array();

    protected $messages = [];

    protected $defaultRule = 'default';
    /**
     * Validation errors
     *
     * @var array
     */
    protected $errors = array();

    /**
     * Set data to validate
     *
     * @param array $data
     * @return self
     */
    public function with(array $data)
    {
        $this->data = $data;

        return $this;
    }


    /**
     * Return errors
     *
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }


    /**
     * Pass the data and the rules to the validator
     *
     * @return boolean
     */
    abstract function isValid();

    /**
     * @param array $newRules set of new validation rules for the current model
     */
    public function setDefault($newDefault)
    {
        $this->defaultRule = $newDefault;
        return $this;
    }

    public function forRequest($rule)
    {
        return $this->setDefault($rule);
    }

    public function forContext($newDetault)
    {
        return $this->setDefault($newDetault);
    }

    public function when($newDefault)
    {
        return $this->setDefault($newDefault);
    }

    public function setMessages($ar)
    {
        $this->messages = $ar;
        return $this;
    }
} 