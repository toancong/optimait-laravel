<?php
Route::get('attachments/delete/{id}', 'Optimait\Laravel\Controllers\AttachmentsController@getDelete');
Route::get('attachments/download/{id}', 'Optimait\Laravel\Controllers\AttachmentsController@getDownload');