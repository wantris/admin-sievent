<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PrestasiEventInternal extends Model
{
    protected $primaryKey = "id_prestasi_event_internal";

    public function eventInternalRegisRef()
    {
        return $this->belongsTo(EventInternalRegistration::class, 'event_internal_registration_id', 'id_event_internal_registration');
    }
}
