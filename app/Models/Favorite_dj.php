<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorite_dj extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'favorite_djs';

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
    protected $fillable = ['dj_id', 'artist_type', 'description', 'image', 'is_approved', 'auth_id'];

    public function dj()
    {
        return $this->belongsTo(\App\User::class, 'dj_id');
    }

    public function dj_profile()
    {
        return $this->hasOne(\App\Profile::class, 'user_id', 'dj_id');
    }

    public function type()
    {
        return $this->belongsTo(Artist::class, 'artist_type');
    }

    public function auth()
    {
        return $this->belongsTo(\App\User::class, 'auth_id');
    }

    
}
