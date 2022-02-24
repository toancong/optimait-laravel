<?php
namespace Optimait\Laravel\Services;


use Optimait\Laravel\Exceptions\ApplicationException;

class UploadService {
    private $handler;
    private $uploadPath;
    private $uploadedName;
    private $fileSize;

    private $supportedTypes = ['csv', 'xml'];



    public function __construct($fileHandler, $uploadPath = './uploads/'){
        $this->handler = $fileHandler;
        $this->uploadPath = rtrim($uploadPath, '/').'/'.date("Y").'/'.date("m").'/';
    }

    public function setSupportedTypes($supportedTypes){
        $this->supportedTypes = $supportedTypes;
        return $this;
    }

    public function checkSupportedTypes(){
        if(!in_array($this->handler->getClientOriginalExtension(), $this->supportedTypes)){
            throw new ApplicationException("Sorry! File cannot be uploaded.");
        }
        return $this;
    }

    public function upload($newFileName = '', \Closure $closure = null){
        if(!is_null($closure)){
            return $closure($this->handler);
        }
        else{
            if($newFileName != ''){
                $this->uploadedName = $newFileName;
            }
            else{
                $this->uploadedName = '_'.time().str_random(15).'.'.$this->handler->getClientOriginalExtension();
            }
            $this->fileSize = $this->handler->getClientSize();
            if (!\File::isDirectory($this->uploadPath)) {
                \File::makeDirectory($this->uploadPath, 0777, true, true);
            }
            return copy($this->handler->getPathname(), $this->getFullPath());
        }
    }


    public function getUploadedName(){
        return $this->uploadedName;
    }

    public function getUploadPath(){
        return $this->uploadPath;
    }

    public function getFullPath(){
        return rtrim($this->uploadPath, '/').'/'.$this->uploadedName;
    }

    public function getFileSize(){
        return $this->fileSize;
    }

    public function __call($name, $args){

        if(empty($args)){
            return $this->handler->$name();
        }
        return $this->handler->$name($args);
    }
} 
