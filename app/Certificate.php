<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    protected $table = 'certificate';
    protected $fillable = [
        'user_id',
        'course_id',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(\App\User::class, 'user_id', 'id');
    }

    public function course()
    {
        return $this->belongsTo(\App\Product::class, 'course_id', 'id');
    }
}
