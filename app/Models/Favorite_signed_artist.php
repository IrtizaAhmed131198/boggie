<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorite_signed_artist extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'favorite_signed_artists';

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
    protected $fillable = ['signed_artist_id', 'description', 'image', 'is_approved', 'auth_id'];

    
}
