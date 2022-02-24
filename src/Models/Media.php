<?php

namespace Optimait\Laravel\Models;


class Media extends \Eloquent
{
    protected $table = 'media';
    protected $fillable = array('filename', 'original_name', 'mime_type', 'filesize', 'folder');

    public $timestamps = false;


    /**
     * Has one relations
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function attachments()
    {
        return $this->hasOne('Optimait\Laravel\Models', 'media_id');
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

    public function deleteFromDisk($original = false){
        $sizes = array_values(config('resize.sizes'));
        foreach($sizes as $size){
            @unlink($this->folder .$size[0].'X'.$size[1]. $this->filename);
        }

        if($original){
            @unlink($this->folder. $this->filename);
        }

    }

    public function selfDestruct()
    {

        //@unlink($this->folder. $this->filename);
        return $this->delete();
    }

}