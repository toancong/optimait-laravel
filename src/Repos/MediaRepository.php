<?php
namespace Optimait\Laravel\Repos;

use Optimait\Laravel\Models\Media;
use Optimait\Laravel\Validators\MediaValidator;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

class MediaRepository extends EloquentRepository
{


    public $validator;

    protected $insertedId;
    protected $optionsView;


    public function __construct(Media $media, MediaValidator $mediaValidator)
    {
        $this->model = $media;
        $this->validator = $mediaValidator;
    }


    /**
     * get the medias for the provided ids
     *
     * @param array $ids
     * @return array|\Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getIn(array $ids)
    {
        return $this->model->whereIn('id', $ids)->get();
    }

    /**
     * @param $mediaData
     * @return bool
     */
    public function createMedia($mediaData)
    {


        /*$finalData = $mediaData-except(array('password'));
        print_r($finalData);*/

        $mediaModel = parent::getNew($mediaData);
        $mediaModel->slug = \Str::slug($mediaData['name'], '-');
        if ($mediaModel->save()) {
            $this->insertedId = $mediaModel->id;
            return true;
        }
        return false;


    }


    /**
     * @param $mediaData
     * @return bool
     */
    public function updateMedia($id, $mediaData)
    {

        $mediaModel = $this->getById($id);


        $mediaModel->fill($mediaData);
        $mediaModel->slug = \Str::slug($mediaData['name'], '-');
        if ($mediaModel->save()) {
            return true;
        }

        /*$mediaModel->update($mediaData);*/

        return false;

    }


    public function getInsertedId()
    {
        return $this->insertedId;
    }

    /**
     * @param $email the mail used to check the duplicate record in the db
     * @return int
     */
    public function checkDuplicateMedias($email)
    {
        //echo $email;
        return $this->model->where('email', $email)->count();
        //print_r(\DB::getQueryLog());
    }

    public function deleteMedia($id)
    {
        $media = $this->getById($id);
        if(is_null($media)){
            throw new ResourceNotFoundException('Media Not Found');
        }

        /*$name = $media->filename;
        @unlink('./uploads/medias/'.$name);*/
        if ($media->selfDestruct()) {
            // print_r(DB::getQueryLog());
            return true;
        }

        return false;
    }
}