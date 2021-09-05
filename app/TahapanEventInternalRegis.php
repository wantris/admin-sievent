<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TahapanEventInternalRegis extends Model
{
    protected $primaryKey = "id_tahapan_event_regis";

    public function tahapanEventInternal()
    {
        return $this->belongsTo(TahapanEventInternal::class, 'tahapan_event_internal_id', 'id_tahapan_event_internal');
    }
}
