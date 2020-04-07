<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Category extends Model
{
     /**
      * The attributes that are mass assignable.
      *
      * @var array
      */
    protected $fillable = [
        'title', 'parent_id', 'image', 'status', 'type'
    ];

    protected $attributes = [
        'status' => 1,
        'image' => '',
        'parent_id' => null,
        'type' => 'post'
    ];

    function getTitleAttribute($value) {
    	return ucfirst($value);
    }

    function getStatusAttribute($status) {
      if($status == 1) { return 'Active'; }
      return 'Inactive';
    }

    function getImageAttribute($image) {
      if($image) {
          return asset("asset/category/$image");
      }
    }

    function getCreatedAtAttribute($value) {
    	if($value) {
    		return $value;
    	}
    	return '';
    }

}
