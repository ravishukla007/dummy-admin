<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Post extends Model
{
	/**
      * The attributes that are mass assignable.
      *
      * @var array
      */
    protected $fillable = [
        'category', 'description', 'user_id', 'status', 'title', 'image', 'asset_url', 'type', 'age_group'
    ];

    protected $attributes = [
        'status' => 0,
        'type' => 0,
        'age_group' => '3-to-5'
    ];

    function getAgeGroupAttribute($age_group) {
      if($age_group == '3-to-5') {
        return '3 to 5';
      } else if($age_group == '6-to-7') {
        return '6 to 7';
      }
      return '8 to 13';
    }
    function getTypeAttribute($type) {
      if($type == 0) {
        return 'Image';
      } else if($type == 1) {
        return 'Video';
      }
      return 'PDF';
    }
    function getTitleAttribute($type) {
      if($type) {
        return ucfirst($type);
      }
      return 'N/A';
    }

    function getStatusAttribute($status) {
    	if($status == 0) { return 'Pending';}
    	if($status == 1) { return 'Active';}
    	if($status == 2) { return 'Inactive';}
    	if($status == 3) { return 'Reject';}
    }

}
