<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    protected $table = 'contents';

    protected $fillable = ['chapter_id', 'content_title', 'content_type', 'content_file', 'content_link'];

    public function chapter()
    {
        return $this->belongsTo(Chapter::class);
    }
}
