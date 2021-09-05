<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventInternalRegistration extends Model
{
    protected $primaryKey = "id_event_internal_registration";

    protected $casts = [
        'created_at' => 'date:Y-m-d',
    ];

    public function eventInternalRef()
    {
        return $this->belongsTo(EventInternal::class, 'event_internal_id', 'id_event_internal');
    }

    public function penggunaMhsRef()
    {
        return $this->belongsTo(Pengguna::class, 'nim', 'nim');
    }

    public function participantRef()
    {
        return $this->belongsTo(Participant::class, 'participant_id', 'id_participant');
    }

    public function timRef()
    {
        return $this->belongsTo(TimEvent::class, 'tim_event_id', 'id_tim_event');
    }

    public function fileEiRegisRef()
    {
        return $this->hasMany(FileEventInternalRegistration::class, 'event_internal_regis_id', 'id_event_internal_registration');
    }

    public function prestasiRef()
    {
        return $this->hasOne(PrestasiEventInternal::class, 'event_internal_registration_id', 'id_event_internal_registration');
    }

    public function tahapanRegisRef()
    {
        return $this->hasMany(TahapanEventInternalRegis::class, 'event_internal_regis_id', 'id_event_internal_registration')->orderBy('created_at', 'DESC');
    }

    public function sertifikatRef()
    {
        return $this->hasOne(SertifikatEventInternal::class, 'event_internal_regis_id', 'id_event_internal_registration');
    }
}
