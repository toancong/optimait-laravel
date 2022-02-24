<?php

namespace Optimait\Laravel\Services\Image;

use Image;


class ImageManipulator
{


    public function resize($filename, $uploadFolder)
    {

        $sizes = config('resize.sizes');
        foreach ($sizes as $thumb => $size) {
            $img = Image::make($uploadFolder . $filename);
            if (isset($size[2])) {
                switch ($size[2]) {
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
                }

            } else {
                $img->resize($size[0], $size[1]);
            }

            $img->save($uploadFolder . $thumb . $filename);
        }

    }
} 
