<?php


Route::get('/', function () {
    return view('welcome');
});

Route::get('upload','UploadController@getIndex');
Route::get('preview','UploadController@getPreview');
Route::post('action','UploadController@postAction');
