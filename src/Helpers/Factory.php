<?php
/**
 * Created by PhpStorm.
 * User: Zorro
 * Date: 5/31/2016
 * Time: 11:44 AM
 */

namespace Optimait\Laravel\Helpers;


class Factory
{


    public static function UploadService($fileHandler, $path)
    {
        return new \Optimait\Laravel\Services\UploadService($fileHandler, $path);
    }

    public static function NewAttachment($data = array())
    {
        /*print_r($data);
        die();*/
        $media = new \Optimait\Laravel\Models\Media($data);
        $media->save();
        return new \Optimait\Laravel\Models\Attachment(array(
            'media_id' => $media->id,
            'type' => @$data['type'],
            'title' => @$data['title'],
            'created_by' => \Auth::id() ? \Auth::id() : 0));
    }
}