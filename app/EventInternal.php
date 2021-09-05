<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\EventInternalDetail;
use Illuminate\Support\Str;

class EventInternal extends Model
{
    protected $primaryKey = "id_event_internal";

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
    ];

    protected $appends = ['poster_image_url', 'banner_image_url'];

    public function getPosterImageUrlAttribute($value)
    {
        return request()->getSchemeAndHttpHost() . '/assets/img/kompetisi-thumb/' . $this->poster_image;
    }

    public function getBannerImageUrlAttribute($value)
    {
        return request()->getSchemeAndHttpHost() . '/assets/img/banner-komp/' . $this->banner_image;
    }

    public function getDeskripsiExcerptAttribute()
    {
        return Str::words($this->deskripsi, '12');
    }

    public function ormawaRef()
    {
        return $this->hasOne(Ormawa::class, 'id_ormawa',  'ormawa_id');
    }

    public function kategoriRef()
    {
        return $this->hasOne(KategoriEvent::class, 'id_kategori', 'kategori_id');
    }

    public function tipePesertaRef()
    {
        return $this->hasOne(TipePeserta::class, 'id_tipe_peserta', 'tipe_peserta_id');
    }

    public function pengajuanRef()
    {
        return $this->hasOne(EventInternalDetail::class, 'event_internal_id',  'id_event_internal');
    }

    public function tahapanRef()
    {
        return $this->hasMany(TahapanEventInternal::class, 'event_internal_id', 'id_event_internal');
    }
}
