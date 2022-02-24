<?php
/**
 * Created by PhpStorm.
 * User: optima
 * Date: 8/23/16
 * Time: 11:03 AM
 */

namespace Optimait\Laravel\Services\Image;


use Intervention\Image\ImageManager;

class TextToImage
{
    private $folder = './uploads/fonts/';
    private $name;
    private $width = 300;
    private $height = 200;
    private $font;
    private $text;
    private $imageService;
    private $imageResource;

    const FONT_SIZE = 50;

    public function __construct()
    {
        $this->imageService = new ImageManager(array('driver' => 'gd'));
    }

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param mixed $text
     * @return TextToImage
     */
    public function setText($text)
    {
        $this->text = $text;
        return $this;
    }


    /**
     * @return string
     */
    public function getFolder()
    {
        return $this->folder;
    }

    /**
     * @param string $folder
     * @return TextToImage
     */
    public function at($folder)
    {
        $this->folder = $folder;
        return $this;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @param int $width
     * @return TextToImage
     */
    public function setWidth($width)
    {
        $this->width = $width;
        return $this;
    }

    /**
     * @return int
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @param int $height
     * @return TextToImage
     */
    public function setHeight($height)
    {
        $this->height = $height;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFont()
    {
        return $this->font;
    }

    /**
     * @param mixed $font
     * @return TextToImage
     */
    public function setFont($font)
    {
        $this->font = $font;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getImageService()
    {
        return $this->imageService;
    }

    /**
     * @param mixed $imageService
     * @return TextToImage
     */
    public function setImageService($imageService)
    {
        $this->imageService = $imageService;
        return $this;
    }

    public function setDynamicSize()
    {
        $this->setWidth(10 * strlen($this->getText()) + 100);
        $this->setHeight(self::FONT_SIZE + 10);
        return $this;
    }


    public function generate()
    {
       /* echo $this->width;
        echo $this->height;*/
        $this->imageResource = $this->imageService->canvas($this->width, $this->height);
        $this->imageResource->text($this->getText(), $this->width / 2, $this->height / 2, function ($font) {
            $font->file($this->getFont());
            $font->size(50);
            $font->color('#000000');
            $font->align('center');
            $font->valign('center');
            $font->angle(0);
        });

        return $this;
    }

    public function getFullPath()
    {
        return $this->getFolder() . $this->getName();
    }

    public function save()
    {
        $this->imageResource->save($this->getFullPath());
    }

    public function stream()
    {
        return $this->imageResource->encode('data-url', 60);
    }


}