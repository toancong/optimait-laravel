<?php
/**
 * Created by PhpStorm.
 * User: baghraja
 * Date: 11/29/18
 * Time: 1:40 PM
 */

namespace Optimait\Laravel\Services\Image;


use App\Services\Image\Resize\Contracts\SourceInterface;
use App\Services\Image\Resize\Source;
use Intervention\Image\Facades\Image;

class Watermark
{
    private $waterMarkSource;
    private $waterMarkHeight = 200;
    private $waterMarkWidth = 250;

    /**
     * @return int
     */
    public function getWaterMarkHeight(): int
    {
        return $this->waterMarkHeight;
    }

    /**
     * @param int $waterMarkHeight
     * @return Watermark
     */
    public function setWaterMarkHeight(int $waterMarkHeight): Watermark
    {
        $this->waterMarkHeight = $waterMarkHeight;
        return $this;
    }

    /**
     * @return int
     */
    public function getWaterMarkWidth(): int
    {
        return $this->waterMarkWidth;
    }

    /**
     * @param int $waterMarkWidth
     * @return Watermark
     */
    public function setWaterMarkWidth(int $waterMarkWidth): Watermark
    {
        $this->waterMarkWidth = $waterMarkWidth;
        return $this;
    }

    public function __construct($waterMarkSource = null)
    {
        if (is_null($waterMarkSource)) {
            $this->setDefault();
        } else {
            $this->waterMarkSource = $waterMarkSource;
        }
    }

    public function setDefault()
    {
        $this->waterMarkSource = new Source('watermark.png');
    }


    public function generate(SourceInterface $source)
    {
        $watermark = Image::make($this->waterMarkSource->getDisk()->get($this->waterMarkSource->getSourcePath()));
        $img = Image::make($source->getDisk()->get($source->getSourcePath()));


        // resize watermark width keep height auto
        $watermark->resize($this->waterMarkWidth, null, function ($constraint) {
            $constraint->aspectRatio();
        });
        //insert resized watermark to image center aligned
        $img->insert($watermark, 'center');

        return $img->encode('data-url');
    }


    public static function InImage(SourceInterface $source, $callable = null)
    {
        $watermark = new Watermark();
        if (!is_null($callable) && is_callable($callable)) {
            $callable($watermark);
        }

        return $watermark->generate($source);
    }
}