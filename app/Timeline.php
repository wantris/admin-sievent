<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Timeline extends Model
{
    protected $primaryKey = "id_timeline";

    public function eventInternalRef(){
        return $this->belongsTo(EventInternal::class, 'event_internal_id','id_event_internal');
    }

    public function eventEksternalRef(){
        return $this->belongsTo(EventEksternal::class, 'event_eksternal_id','id_event_eksternal');
    }
}
