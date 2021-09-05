<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Serializable;

class Ormawa extends Model
{
    protected $primaryKey = "id_ormawa";

    protected $casts = [
        'created_at' => 'datetime:Y-m-d',
    ];

    protected $appends = ['photo_image_url', 'banner_image_url'];

    public function getPhotoImageUrlAttribute($value)
    {
        return request()->getSchemeAndHttpHost() . '/assets/img/ormawa-logo/' . $this->photo;
    }

    public function getBannerImageUrlAttribute($value)
    {
        return request()->getSchemeAndHttpHost() . '/assets/img/banner-ormawa/' . $this->banner;
    }
}
