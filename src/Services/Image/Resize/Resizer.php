<?php

namespace Optimait\Laravel\Services\Image\Resize;

use Optimait\Laravel\Services\Image\Resize\Contracts\DestinationContract;
use Optimait\Laravel\Services\Image\Resize\Contracts\SourceInterface;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class Resizer
{
    private $source;
    private $generatedThumbs = [];

    public function __construct(SourceInterface $source)
    {
        $this->source = $source;
    }

    public function resize(DestinationContract $destination)
    {
        $sizes = config('resize.sizes');

        /*$basePath = $this->source->getDisk()->getDriver()->getAdapter()->getPathPrefix();
        $fullPath = $basePath . $this->source->getSourcePath();
        ed($fullPath);
        $newPath = $fullPath;*/

        $img = Image::make($this->source->getDisk()->get($this->source->getSourcePath()));
        $img->backup();

        foreach ($sizes as $sizeName => $size) {

            $rule = isset($size[2]) ? $size[2] : null;

            switch ($rule) {
                case 'width':
                    $img->resize(null, $size[1], function ($constraint) {
                        $constraint->aspectRatio();
                        //$constraint->upsize();
                    });
                    break;
                case 'height':
                    $img->resize($size[0], null, function ($constraint) {
                        $constraint->aspectRatio();
                        //$constraint->upsize();
                    });
                    break;
                case 'fit':
                    $img->fit($size[0], $size[1]);
                    break;
                default:
                    $img->resize($size[0], $size[1]);
                    break;
            }
            $this->generatedThumbs[] = $destination->setPrefix($sizeName)->save($this->source, $img);
            $img->restore();
        }

        return $this->generatedThumbs;
    }
}
