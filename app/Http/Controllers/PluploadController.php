<?php

namespace App\Http\Controllers;

use App\Model\Image;
use Illuminate\Http\Request;

class PluploadController extends Controller
{
  public function Index(){
    $images = Image::orderBy('id','desc')->get();
    return view('plupload.index',['images' => $images]);
  }

  public function Preview(){
    $images = Image::orderBy('id','desc')->get();
    return view('plupload.preview',['images' => $images]);
  }

  public function Action(Request $request){
   if($request->exists('btn-multiupload')){
      $file = $request->file('file');
      $path = 'images/uploads/';
      $filename = $file->getClientOriginalName();
      $file->move('images/uploads/plupload/',$file->getClientOriginalName());
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
