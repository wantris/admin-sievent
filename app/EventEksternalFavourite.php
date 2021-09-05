<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventEksternalFavourite extends Model
{
    protected $primaryKey = "id_event_eksternal_favourites";

    public function eventEksternalRef()
    {
        return $this->belongsTo(EventEksternal::class, 'event_eksternal_id', 'id_event_eksternal');
    }
}
