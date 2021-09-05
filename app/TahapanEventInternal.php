<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TahapanEventInternal extends Model
{
    protected $primaryKey = "id_tahapan_event_internal";

    public function eventInternalRef()
    {
        return $this->belongsTo(EventInternal::class, 'event_internal_id', 'id_event_internal');
    }
}
