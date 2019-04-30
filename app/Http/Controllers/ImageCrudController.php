<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\ImageGallery;
class ImageCrudController extends Controller
{
  public function index()
  {
    return view('image_upload.index');
  }

  public function store(Request $request)
  {
    $image = new ImageGallery();
    $image->imageGalleryUpload('imageGalleries',new ImageGallery(),'Image_Crud/',1,'image');
  }

  public function edit($id)
  {
    $images = ImageGallery::where('product_id',$id)->get();
    return view('image_upload.edit',compact('images'));
  }

  public function update(Request $request, $id)
  {
    $images = ImageGallery::where('product_id',$id)->get();
    // return $images;
    //store old image
    foreach ($images as $key => $image) {
      $old_image []=$image;
    }
    // delete old image
    foreach ($images as $key => $image) {
      $image->delete();
    }
    foreach ($old_image as $key => $image) {
      $save = new ImageGallery();
      $data = array(
        'image' => $image->image,
        'product_id'=>1
      );
      $save->create($data);
    }
  }

  public function destroy($id)
  {

  }

}
