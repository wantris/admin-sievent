<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventInternalFavourite extends Model
{
    protected $primaryKey = "id_event_internal_favourites";

    public function eventInternalRef()
    {
        return $this->belongsTo(EventInternal::class, 'event_internal_id', 'id_event_internal');
    }
}
