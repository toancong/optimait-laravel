<?php
namespace Optimait\Laravel\Exceptions;


class ValidationException extends \Exception {

    private $errors;

    public function __construct($message, $errors = false){
        parent::__construct($message);
        $this->errors = $errors;
    }

    public function getErrors(){
        return $this->errors;
    }
} 