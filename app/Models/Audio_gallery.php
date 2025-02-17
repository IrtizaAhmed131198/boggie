<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Audio_gallery extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'audio_galleries';

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
    protected $fillable = ['category', 'audio_title', 'description', 'file', 'image', 'duration', 'language', 'genre', 'free_style_name', 'price', 'is_approved', 'auth_id'];

    protected $appends = ['audio_link', 'image_link'];

    public function getAudioLinkAttribute()
    {
        return url($this->file);
    }
    
    public function getImageLinkAttribute()
    {
        if (!empty($this->image)) {
            return url($this->image);
        } else {
            return url('assets/imgs/noimage.png');
        }
    }

    public function auth()
    {
        return $this->belongsTo(\App\User::class, 'auth_id');
    }
}
