<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TimEvent extends Model
{
    protected $primaryKey = "id_tim_event";

    protected $casts = [
        'created_at' => 'date:Y-m-d',
    ];


    public function timDetailRef()
    {
        return $this->hasMany(TimEventDetail::class, 'tim_event_id', 'id_tim_event');
    }

    public function eventInternalRegisRef()
    {
        return $this->hasOne(EventInternalRegistration::class, 'tim_event_id', 'id_tim_event');
    }

    public function eventEksternalRegisRef()
    {
        return $this->hasOne(EventEksternalRegistration::class, 'tim_event_id', 'id_tim_event');
    }
}
