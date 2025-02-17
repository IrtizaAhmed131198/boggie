<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User_two extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user_twos';

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
    protected $fillable = ['auth_id', 'is_featured'];

    
}
