<?php

namespace App\Http\Controllers;

use App\Model\Image;
use Illuminate\Http\Request;

class UploadController extends Controller
{
  public function getIndex(){
    $images = Image::orderBy('id','desc')->get();
    return view('admin.upload.index',['images' => $images]);
  }

  public function getPreview(){
    $images = Image::orderBy('id','desc')->get();
    return view('admin.upload.preview',['images' => $images]);
  }

  public function postAction(Request $request){
   if($request->exists('btn-multiupload')){
      $file = $request->file('file');
      $path = 'images/uploads';
      $filename = $file->getClientOriginalName();
      $file->move('images/uploads',$file->getClientOriginalName());
      $image = new Image;
      $image->image_name = $filename;
      $image->save();
      echo 'Uploaded';
    }
  }
  public function getTestpackage(){
      $img = Image::make('images/uploads/Koala.jpg')->resize(300, 200);
      return $img->response('jpg');
  }
}
