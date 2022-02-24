<?php
namespace Optimait\Laravel\Services\Validation;


interface ValidationService {

    /**
     * With
     *
     * @param array
     * @return self
     */
    public function with(array $input);

    /**
     * Passes
     *
     * @return boolean
     */
    public function isValid();

    /**
     * Errors
     *
     * @return array
     */
    public function getErrors();
} 