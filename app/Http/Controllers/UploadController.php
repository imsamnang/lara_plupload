<?php

namespace App\Http\Controllers;

use App\Model\Image;
use App\Model\Product;
use App\Model\ProductPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

  public function ajaxForm()
  {
    return view('ajax_multi_upload.index');
  }

  public function ajaxUpload(Request $request)
  {
    if ($request->images) {
      $images = $request->images;
      $total = $request->TotalImages;
      $imagesName = $images->getClientOriginalName();
      $randonName = rand(1, 200);
      $images->move(public_path('/images/test'), $randonName . '.jpg');
      return response()->json($randonName);
    }
  }


  public function uploadForm()
  {
      return view('upload_form');
  }

  public function uploadSubmit(Request $request)
  {
    $photos = [];
    foreach ($request->photos as $photo) {
        $filename = $photo->store('photos');
        $product_photo = ProductPhoto::create([
            'filename' => $filename
        ]);
        $photo_object = new \stdClass();
        $photo_object->name = str_replace('photos/', '',$photo->getClientOriginalName());
        $photo_object->size = round(Storage::size($filename) / 1024, 2);
        $photo_object->fileID = $product_photo->id;
        $photos[] = $photo_object;
    }
    return response()->json(array('files' => $photos), 200);
  }

  public function postProduct(Request $request)
  {
    $product = Product::create($request->all());
    ProductPhoto::whereIn('id', explode(",", $request->file_ids))
        ->update(['product_id' => $product->id]);
    return 'Product saved successfully';
  }


}
