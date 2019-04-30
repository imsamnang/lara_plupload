<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Upload as upload;

class ImageGallery extends upload
{
    protected $table = 'image_gallery';
    protected $fillable = ['image','product_id'];
}
