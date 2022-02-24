<?php
/**
 * Created by PhpStorm.
 * User: Zorro
 * Date: 5/30/2016
 * Time: 1:16 PM
 */

namespace Optimait\Laravel\Models;


use Optimait\Laravel\Services\Image\ImageManipulator;
use Optimait\Laravel\Traits\CreatedUpdatedTrait;
use Optimait\Laravel\Traits\CreaterUpdaterTrait;

class Attachment extends \Eloquent
{
    use CreatedUpdatedTrait, CreaterUpdaterTrait;
    protected $table = 'attachments';
    protected $fillable = array('media_id', 'created_by', 'attachable_id', 'attachable_type', 'type', 'title');
    protected $with = array('media');

    /*public $timestamps = false;*/


    /**
     * Polymorphic relations
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function attachable()
    {
        return $this->morphTo();
    }


    /**
     * belongs to relations
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function media()
    {
        return $this->hasOne('Optimait\Laravel\Models\Media', 'id', 'media_id');
    }


    /**
     * one to one relationship with the users
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo('App\User', 'created_by');
    }


    public function getDownloadUrl()
    {
        return url('attachments/download/' . encrypt($this->id));
    }

    public function getFileUrl()
    {
        return asset($this->media->folder . $this->media->filename);
    }


    public function getThumbUrl($thumb = 'thumb')
    {
        //$size = config('resize.sizes.' . $thumb);
        return asset($this->media->folder . $thumb . $this->media->filename);
    }


    public function getPath($thumb = null)
    {
        if (!is_null($thumb)) {
            //$size = config('resize.sizes.' . $thumb);
            return public_path($this->media->folder . $thumb . $this->media->filename);
        }

        return public_path($this->media->folder . $this->media->filename);
    }

    public function isImage()
    {
        return @substr($this->media->mime_type, 0, 5) == 'image';
    }

    public function resize(ImageManipulator $manipulator)
    {

        if (\File::exists($this->media->folder . $this->media->filename)) {
            $this->media->deleteFromDisk();
            $manipulator->resize($this->media->filename, $this->media->folder);
        }
    }

    public function selfDestruct($physicalDelete = false)
    {
        if ($physicalDelete) {
            $this->media->deleteFromDisk(true);
            $this->media->selfDestruct();
        }
        /*foreach($this->sizes as $size){
            @unlink('./uploads/attachments/' .$size[0].'X'.$size[1]. $this->filename);
        }

        @unlink('./uploads/attachments/' . $this->filename);
        @unlink('./uploads/documents/' . $this->filename);*/
        return $this->delete();
    }

}