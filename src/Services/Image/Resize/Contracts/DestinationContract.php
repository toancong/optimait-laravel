<?php
/**
 * Created by PhpStorm.
 * User: baghraja
 * Date: 11/27/18
 * Time: 12:36 AM
 */

namespace Optimait\Laravel\Services\Image\Resize\Contracts;


interface DestinationContract
{
    public function setPrefix($prefix);
    public function setRelativePath($path);
    public function save(SourceInterface $source, $interventionImageInstance);

}