<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    protected $table = 'chapters';

    protected $fillable = ['course_id', 'chapter_title', 'chapter_number'];

    public function course()
    {
        return $this->belongsTo(Product::class);
    }

    public function contents()
    {
        return $this->hasMany(Content::class);
    }
}
