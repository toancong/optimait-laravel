<?php

namespace Optimait\Laravel\Services\Export;


abstract class AbstractExporter {

    protected $heading;
    protected $filename;

    public function setHeadings($array){
        $this->heading = $array;
        return $this;
    }

    public function setName($name){
        $this->filename = $name;
        return $this;
    }
    public abstract function export($data);
} 