<?php

namespace App\Model;

use App\Model\ProductGallery;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class Upload extends Model
{
  //use with store function in controller
	public static function imageUpload($filename,$ObjModel, $path = null)
  {
  	if(request()->hasfile($filename))
  	{
      $dir = 'uploads/' . $path .'/';
  		$file = request()->file($filename);
  		$extension = $file->getClientOriginalExtension();
  		$filename = time().'.'.$extension;
  		$file->move($dir,$filename);
  		$ObjModel->image = $filename;
  	}
  }
  //use with update function in controller
  public static function imageUpdate($filename,$ObjModel, $path = null)
  {
    $dir = 'uploads/'. $path .'/';
    $oldfilename = $ObjModel->image;
    if(request()->hasfile($filename))
    {
      if ($ObjModel->image != '' && File::exists($dir . $ObjModel->image))
        File::delete($dir . $ObjModel->image);
        $file = request()->file($filename);
        $extension = $file->getClientOriginalExtension();
        $filename = time().'.'.$extension;
        $file->move($dir,$filename);
        $ObjModel->image = $filename;
      } elseif (request()->remove == 1 && File::exists('uploads/' . $path .'/'. $ObjModel->image)){
          File::delete($dir . $ObjModel->image);
        $ObjModel->image = null;
      } else {
        $ObjModel->image = $oldfilename;
      }

  }
//use with destroy or delete function in controller
  public static function imageDelete($filename,$ObjModel, $path = null)
  {
    $dir = 'uploads/'. $path .'/';
    if ($ObjModel->image != '' && File::exists($dir . $ObjModel->image)){
      File::delete($dir . $ObjModel->image);
    }
  }

  public static function imageGalleryUpload($filename,$ObjModel, $path = null,$product_id,$fieldID)
  {
    if(request()->hasFile($filename)){
      $dir = 'uploads/' . $path .'/';
      foreach (request()->$filename as $file) {
        $filename = rand(). '.' . $file->getClientOriginalExtension();
        $ObjModel = new $ObjModel;
				$ObjModel->product_id=$product_id;
        $ObjModel->$fieldID = $filename;
        if($ObjModel->save()){
          $file->move($dir,$filename);
        }
      }
    }
  }



}
