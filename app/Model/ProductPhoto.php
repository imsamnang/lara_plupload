<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ProductPhoto extends Model
{
  protected $fillable = ['product_id', 'filename'];

  public function product()
  {
      return $this->belongsTo('App\Model\Product');
  }
}
