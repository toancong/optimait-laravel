<?php
/**
 * Created by PhpStorm.
 * User: zorro
 * Date: 5/26/2015
 * Time: 1:19 PM
 */

namespace Optimait\Laravel\Traits;

use Optimait\Laravel\Helpers\Factory;
use Optimait\Laravel\Helpers\Fetcher;
use Optimait\Laravel\Services\Image\ImageManipulator;

trait UploaderTrait
{
    private $attachmentModel;
    private $uploadService;
    private $uploadType = '';
    private $title = '';

    private $uploadPath = './uploads/attachments';

    /**
     * @return string
     */
    public function getUploadPath()
    {
        return $this->uploadPath;
    }

    /**
     * @param string $uploadPath
     */
    public function setUploadPath($uploadPath)
    {
        $this->uploadPath = $uploadPath;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAttachmentModel()
    {
        return $this->attachmentModel;
    }


    /**
     * @return mixed
     */
    public function getUploadService()
    {
        return $this->uploadService;
    }


    /**
     * @return string
     */
    public function getUploadType()
    {
        return $this->uploadType;
    }

    /**
     * @param string $uploadType
     */
    public function setUploadType($uploadType)
    {
        $this->uploadType = $uploadType;
        return $this;
    }


    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }


    public function uploadMedia($fileHandler, $resize = false)
    {
        $this->attachMedia($fileHandler);
        /*$model->attachments()->save($this->getAttachmentModel());*/
        if ($resize) {
            $this->resize();
        }

        $this->getAttachmentModel()->save();
        return $this->getAttachmentModel();
    }

    public function uploadMediaForModel($model, $fileHandler, $dynamicAttachment = null, $resize = false)
    {
        $this->attachMedia($fileHandler);
        if (!is_null($dynamicAttachment) && is_callable($dynamicAttachment)) {
            $dynamicAttachment($model, $this->getAttachmentModel());
        } else {
            $model->attachments()->save($this->getAttachmentModel());
        }

        if ($resize) {
            $this->resize();
        }


        return $this->getAttachmentModel();
    }


    public function uploadFileForModel($model, $attachmentModel, $dynamicAttachment = null, $resize = false)
    {
        if (!is_null($dynamicAttachment) && is_callable($dynamicAttachment)) {
            $dynamicAttachment($model, $attachmentModel);
        } else {
            $model->attachments()->save($attachmentModel);
        }

        if ($resize) {
            $this->resize();
        }


        return $this->getAttachmentModel();
    }


    public function attachMedia($fileHandler)
    {
        if (is_null($fileHandler)) {
            return '';
        }
        $this->uploadService = Factory::UploadService($fileHandler, $this->getUploadPath());
        $this->uploadService->upload();
        $this->attachmentModel = Factory::NewAttachment(array(
            'filename' => $this->uploadService->getUploadedName(),
            'original_name' => $this->uploadService->getClientOriginalName(),
            'folder' => $this->uploadService->getUploadPath(),
            'mime_type' => $this->uploadService->getClientMimeType(),
            'filesize' => $this->uploadService->getFileSize(),
            'type' => $this->uploadType,
            'title' => $this->title
        ));

        /*$this->image->resize($this->uploadService->getUploadedName(), $this->uploadService->getUploadPath().'/');*/
        /*return array('id' => $attachmentModel->id, 'service' => $this->uploadService);*/

    }


    public function deleteOldMedia($mediaID, $physicalDelete = false)
    {

        /*lets delete old one*/
        $oldAttachmentModel = Fetcher::FindAttachment($mediaID);
        if (!is_null($oldAttachmentModel)) {
            $oldAttachmentModel->selfDestruct($physicalDelete);
        }
    }


    public function resize()
    {
        $this->uploadService = $this->getUploadService();
        $this->getImageManipulator()->resize($this->uploadService->getUploadedName(), rtrim($this->uploadService->getUploadPath(), '/') . '/');
        /*$source = new Source($this->getUploadService()->getFullPath());
        $destination = new Destination($this->getUploadService()->getUploadPath());
        //ed($source->getSourcePath());
        $resizer = new Resizer($source);
        $resizer->resize($destination);*/
    }


    public function getImageManipulator()
    {
        return new ImageManipulator();
    }


}