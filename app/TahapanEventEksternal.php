<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TahapanEventEksternal extends Model
{
    protected $primaryKey = "id_tahapan_event_eksternal";

    public function eventEksternalRef()
    {
        return $this->belongsTo(Eventeksternal::class, 'event_eksternal_id', 'id_event_eksternal');
    }
}
