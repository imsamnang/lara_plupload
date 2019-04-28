<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ImageGallery extends Model
{
    protected $table = 'image_gallery';
    protected $fillable = ['image'];
}
