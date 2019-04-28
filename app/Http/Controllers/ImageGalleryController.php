<?php

namespace App\Http\Controllers;

use App\Model\ImageGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ImageGalleryController extends Controller
{
  public function index(){
  	$images = ImageGallery::get();
  	return view('image-gallery',compact('images'));
  }

  public function upload(Request $request){
  	$this->validate($request, [
  		// 'title' => 'required',
      // 'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
      ]);
      // $input['image'] = time().'.'.$request->image->getClientOriginalExtension();
      // $request->image->move(public_path('images'), $input['image']);
      // $input['title'] = $request->title;
        if($request->hasfile('image')){
          foreach($request->file('image') as $file){
            $name = time().'-'.$file->getClientOriginalName();
            $file->move(public_path().'/images/gallery/', $name);
            ImageGallery::create(['image'=>$name]);
          }
        }    
  	return back()->with('success','Image Uploaded successfully.');
  }

  public function destroy($id){
  	$image = ImageGallery::find($id);
    $image_path = public_path().'\images/gallery\\'.$image->image;
    if ($image->image != '' && File::exists($image_path)){
      File::delete($image_path);
      $image->destroy($id);        
    }
  	return back()->with('success','Image removed successfully.');	
  }
}

