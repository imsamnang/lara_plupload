<?php


// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('upload','UploadController@getIndex');
Route::get('preview','UploadController@getPreview');
Route::post('action','UploadController@postAction');
Route::get('/', 'UploadController@uploadForm');
Route::post('/upload', 'UploadController@uploadSubmit');
Route::post('/product', 'UploadController@postProduct');

Route::get('ajax_upload','UploadController@ajaxForm');
Route::post('ajax_upload','UploadController@ajaxUpload')->name('image-upload.store');

Route::get('image-gallery', 'ImageGalleryController@index');
Route::post('image-gallery', 'ImageGalleryController@upload');
Route::delete('image-gallery/{id}', 'ImageGalleryController@destroy');

Route::get('images-upload', 'MultiUploadController@imagesUpload');
Route::post('images-upload', 'MultiUploadController@imagesUploadPost')->name('images.upload');

Route::get('uploads', 'ImageUploadController@upload');
Route::post('upload/store', 'ImageUploadController@store');
Route::post('delete', 'ImageUploadController@delete');

