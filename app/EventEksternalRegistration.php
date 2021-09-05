<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventEksternalRegistration extends Model
{
    protected $primaryKey = "id_event_eksternal_registration";

    protected $casts = [
        'created_at' => 'date:Y-m-d',
    ];

    public function eventEksternalRef()
    {
        return $this->belongsTo(EventEksternal::class, 'event_eksternal_id', 'id_event_eksternal');
    }

    public function fileEeRegisRef()
    {
        return $this->hasMany(FileEventEksternalRegistration::class, 'event_eksternal_regis_id', 'id_event_eksternal_registration');
    }

    public function penggunaRef()
    {
        return $this->belongsTo(Pengguna::class, 'nim', 'nim');
    }

    public function timRef()
    {
        return $this->belongsTo(TimEvent::class, 'tim_event_id', 'id_tim_event');
    }

    public function prestasiRef()
    {
        return $this->hasOne(PrestasiEventEksternal::class, 'event_eksternal_regis_id', 'id_event_eksternal_registration');
    }

    public function tahapanRegisRef()
    {
        return $this->hasMany(TahapanEventEksternalRegis::class, 'event_eksternal_regis_id', 'id_event_eksternal_registration')->orderBy('created_at', 'DESC');
    }

    public function sertifikatRef()
    {
        return $this->hasOne(SertifikatEventEksternal::class, 'event_eksternal_regis_id', 'id_event_eksternal_registration');
    }
}
