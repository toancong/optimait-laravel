<?php
/**
 * Created by PhpStorm.
 * User: Zorro
 * Date: 5/30/2016
 * Time: 1:09 PM
 */

namespace Optimait\Laravel\Repos;


use Optimait\Laravel\Models\Attachment;
use Optimait\Laravel\Validators\AttachmentValidator;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

class AttachmentRepository extends EloquentRepository
{
    public function __construct(Attachment $attachment, AttachmentValidator $attachmentValidator)
    {
        $this->model = $attachment;
        $this->validator = $attachmentValidator;
    }


    /**
     * get the attachments for the provided ids
     *
     * @param array $ids
     * @return array|\Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getIn(array $ids)
    {
        return $this->model->whereIn('id', $ids)->get();
    }

    /**
     * @param $attachmentData
     * @return bool
     */
    public function createAttachment($attachmentData)
    {


        /*$finalData = $attachmentData-except(array('password'));
        print_r($finalData);*/

        $attachmentModel = parent::getNew($attachmentData);
        $attachmentModel->slug = str_slug($attachmentData['name'], '-');
        if ($attachmentModel->save()) {
            $this->insertedId = $attachmentModel->id;
            return true;
        }
        return false;


    }


    /**
     * @param $attachmentData
     * @return bool
     */
    public function updateAttachment($id, $attachmentData)
    {

        $attachmentModel = $this->getById($id);


        $attachmentModel->fill($attachmentData);
        $attachmentModel->slug = str_slug($attachmentData['name'], '-');
        if ($attachmentModel->save()) {
            return true;
        }

        /*$attachmentModel->update($attachmentData);*/

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
    public function checkDuplicateAttachments($email)
    {
        //echo $email;
        return $this->model->where('email', $email)->count();
        //print_r(\DB::getQueryLog());
    }

    public function deleteAttachment($id, $physial = false)
    {
        $attachment = $this->getById($id);
        if(is_null($attachment)){
            throw new ResourceNotFoundException('Attachment Not Found');
        }

        /*$name = $attachment->filename;
        @unlink('./uploads/attachments/'.$name);*/
        if ($attachment->selfDestruct($physial)) {
            // print_r(DB::getQueryLog());
            return true;
        }

        return false;
    }
}