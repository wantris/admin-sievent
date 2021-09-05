<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PrestasiEventEksternal extends Model
{
    protected $primaryKey = "id_prestasi_event_eksternal";

    public function eventEksternalRegisRef()
    {
        return $this->belongsTo(EventEksternalRegistration::class, 'event_eksternal_regis_id', 'id_event_eksternal_registration');
    }
}
