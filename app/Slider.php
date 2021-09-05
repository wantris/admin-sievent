<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $primaryKey = "id_slider";

    protected $appends = ['image_url'];

    protected $casts = [
        'created_at' => 'date:Y-m-d',
    ];

    public function getImageUrlAttribute($value)
    {
        return request()->getSchemeAndHttpHost() . '/assets/img/slider/' . $this->image_name;
    }
}
