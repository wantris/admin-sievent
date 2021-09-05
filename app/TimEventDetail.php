<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TimEventDetail extends Model
{
    protected $primaryKey = "id_tim_event_detail";

    protected $casts = [
        'created_at' => 'date:Y-m-d',
    ];

    public function timEventRef()
    {
        return $this->belongsTo(TimEvent::class, 'tim_event_id', 'id_tim_event');
    }

    public function participantRef()
    {
        return $this->belongsTo(Participant::class, 'participant_id', 'id_participant');
    }

    public function penggunaMhsRef()
    {
        return $this->belongsTo(Pengguna::class, 'nim', 'nim');
    }

    public function penggunaParticipantRef()
    {
        return $this->belongsTo(Pengguna::class, 'participant_id', 'participant_id');
    }
}
