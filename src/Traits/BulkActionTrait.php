<?php


namespace Optimait\Laravel\Traits;


use Optimait\Laravel\Exceptions\ApplicationException;
use Input;

trait BulkActionTrait {
    public function postBulkAction(){

            if(!Input::get('id')){
                throw new ApplicationException('Please select at least one item');
            }

            switch(Input::get('action')){
                case 'email':
                    $this->postBulkEmailAction(Input::all());
                    break;

                case 'download':
                    $this->postBulkDownloadAction(Input::all());
                    break;

                case 'delete':
                    $this->postBulkDeleteAction(Input::all());
                    break;
                case 'export':
                    return $this->postBulkExportAction(Input::all());
                    break;
            }

            return redirect()->back()->with('success', 'Action Completed');
        }



} 