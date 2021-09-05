<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Blog extends Model
{
    protected $primaryKey = "id_blog";

    protected $appends = ['image_url'];

    public function getImageUrlAttribute($value)
    {
        return request()->getSchemeAndHttpHost() . '/assets/img/blog/' . $this->image_name;
    }

    public function getKontenExcerptAttribute()
    {
        return Str::words($this->konten, '15');
    }
}
