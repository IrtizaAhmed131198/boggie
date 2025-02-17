<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $guarded= [];

    protected $appends = ['image_link'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function user_profile(){
        return $this->belongsTo(User::class);
    }

    public function getImageLinkAttribute()
    {
        if (!empty($this->pic)) {
            return asset($this->pic);
        } else {
            return asset('assets/imgs/profile.png');
        }
    }
}
