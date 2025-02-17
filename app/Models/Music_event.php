<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Music_event extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'music_events';

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
    protected $fillable = ['event_title', 'description', 'image', 'date', 'time', 'auth_id', 'location', 'event_date', 'event_time'];

    protected $appends = ['image_link', 'format_date'];

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

    public function getFormatDateAttribute()
    {
        $date = $this->event_date;
        $formatted_date = date("d F Y", strtotime($date));
        return $formatted_date;
    }

    
}
