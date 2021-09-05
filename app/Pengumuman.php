<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Pengumuman extends Model
{
    protected $table = "pengumumans";
    protected $primaryKey = "id_pengumuman";

    public function getDeskripsiExcerptAttribute()
    {
        return Str::words($this->deskripsi, '10');
    }

    public function eventInternalRef()
    {
        return $this->belongsTo(EventInternal::class, 'event_internal_id', 'id_event_internal');
    }

    public function eventEksternalRef()
    {
        return $this->belongsTo(EventEksternal::class, 'event_eksternal_id', 'id_event_eksternal');
    }
}
