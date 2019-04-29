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

  public function update($id)
  {

  }

  public function destroy($id)
  {

  }

}
