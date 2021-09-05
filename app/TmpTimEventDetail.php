<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TmpTimEventDetail extends Model
{
    protected $primaryKey = "id_tmp_tim_event_detail";

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
