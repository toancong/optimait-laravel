<?php
/**
 * Created by PhpStorm.
 * User: Zorro
 * Date: 5/30/2016
 * Time: 1:08 PM
 */

namespace Optimait\Laravel\Controllers;


use Illuminate\Routing\Controller;
use Input;
use Optimait\Laravel\Exceptions\EntityNotFoundException;

use Optimait\Laravel\Repos\AttachmentRepository;


class AttachmentsController extends Controller {
    private $attachments;
    public function __construct(AttachmentRepository $attachmentRepository){
        $this->attachments = $attachmentRepository;
    }

    /**
     * Display a listing of the resource.
     * GET /attachments
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     * GET /attachments/create
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     * POST /attachments
     *
     * @return Response
     */
    public function store()
    {
        //
    }

    /**
     * Display the specified resource.
     * GET /attachments/{id}
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * GET /attachments/{id}/edit
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * PUT /attachments/{id}
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * DELETE /attachments/{id}
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }


    public function getDownload($id){
        $attachment = $this->attachments->getById(decrypt($id));
        if(!$attachment){
            throw new EntityNotFoundException("Attachment Not Found");
        }


        return \Response::download($attachment->media->folder.$attachment->media->filename, $attachment->media->original_name);

    }


    public function getDelete($id){
        /*if(!Input::has('_delete_token') || Input::get('_delete_token') != md5($id)){
            throw new \Exception('Token Mismatch');
        }*/
        $id = decrypt($id);

        if($this->attachments->deleteAttachment($id, Input::has('physical'))){
            echo 1;
            exit();
        }
        throw new \Exception('Cannot perform selected action');
    }


    public function postSingleAjaxUpload(){
        $attachment = $this->attachments->uploadMedia(Input::file('media'), Input::get('resize', false));
        $key = Input::get('key');

        return response()->json(array(
            'data' => sysView('attachments.partials.single.for-generator', compact('attachment', 'key'))->render()
        ));
    }

}