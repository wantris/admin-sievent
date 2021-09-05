<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Testimoni extends Model
{
    protected $primaryKey = "id_testimoni";

    protected $appends = ['image_url'];

    public function getImageUrlAttribute($value)
    {
        return request()->getSchemeAndHttpHost() . '/assets/img/testimonial/' . $this->photo;
    }
}
