<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery_picture extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'gallery_pictures';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['artist_id', 'description', 'image', 'is_approved', 'auth_id'];

    protected $appends = ['image_link'];

    public function getImageLinkAttribute()
    {
        if (!empty($this->image)) {
            return url($this->image);
        } else {
            return url('assets/imgs/noimage.png');
        }
    }
}
