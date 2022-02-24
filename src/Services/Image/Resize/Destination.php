<?php
/**
 * Created by PhpStorm.
 * User: baghraja
 * Date: 11/27/18
 * Time: 12:38 AM
 */

namespace Optimait\Laravel\Services\Image\Resize;


use Optimait\Laravel\Services\Image\Resize\Contracts\DestinationContract;
use Optimait\Laravel\Services\Image\Resize\Contracts\SourceInterface;
use Illuminate\Support\Facades\Storage;

class Destination implements DestinationContract
{
    private $prefix = '';
    private $relativePath;

    public function __construct($relativePath = '')
    {
        $this->relativePath = $relativePath;
    }

    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;
        return $this;
    }

    public function setRelativePath($path)
    {
        $this->relativePath = $path;
        return $this;
    }

    public function getDisk()
    {
        return Storage::disk(config('resize.destination_disk'));
    }

    public function save(SourceInterface $source, $interventionImageInstance)
    {
        if ($this->relativePath != '') {
            $this->relativePath = rtrim($this->relativePath, '/') . '/';
        }



        $destination = ltrim($source->getSourceFolder(), '.') . '/' . $this->relativePath . '/' . $this->prefix . '/' .  $source->getSourceFileName();
        /*$img->save($destination);*/
        $this->getDisk()->put($destination, (string)$interventionImageInstance->stream());

        return ['path' => $destination, 'url' => $this->getDisk()->url($destination)];
    }
}
