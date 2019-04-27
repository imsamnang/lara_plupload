<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MultiUploadController extends Controller
{
  public function imagesUpload(){
    return view('imagesUpload');
  }

  public function imagesUploadPost(Request $request){
    request()->validate([
        'uploadFile' => 'required',
    ]);
    foreach ($request->file('uploadFile') as $key => $value) {
      $imageName = time(). $key . '.' . $value->getClientOriginalExtension();
      $value->move(public_path('images'), $imageName);
    }
    return response()->json(['success'=>'Images Uploaded Successfully.']);
  }
}
