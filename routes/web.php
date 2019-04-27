<?php


Route::get('/', function () {
    return view('welcome');
});

Route::get('upload','UploadController@getIndex');
Route::get('preview','UploadController@getPreview');
Route::post('action','UploadController@postAction');

Route::get('ajax_upload','UploadController@ajaxForm');
Route::post('ajax_upload','UploadController@ajaxUpload')->name('image-upload.store');
