<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class School extends Model
{
	/**
      * The attributes that are mass assignable.
      *
      * @var array
      */
    protected $fillable = [
        'name', 'logo', 'description', 'status'
    ];

    protected $attributes = [
        'status' => 0
    ];

    function getNameAttribute($name) {
      return ucfirst($name);
    }

    function getStatusAttribute($status) {
      if($status == 0) { return 'Inactive'; }
      return 'Active';
    }

}
