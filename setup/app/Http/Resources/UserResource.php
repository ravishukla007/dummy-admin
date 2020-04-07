<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;

class UserResource extends JsonResource
{ 
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            '_id' => $this->_id, 
            'name' => $this->name, 
            'email' => $this->email,
            'mobile_number' => $this->mobile_number,
            'profile_image' => $this->avatar,  
        ];
    }
}
