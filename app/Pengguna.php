<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pengguna extends Model
{
    protected $primaryKey = "id_pengguna";

    public function pembinaRef()
    {
        return $this->hasOne(Pembina::class, 'id_pembina', 'pembina_id');
    }

    public function participantRef()
    {
        return $this->hasOne(Participant::class, 'id_participant', 'participant_id');
    }

    public function wadir3Ref()
    {
        return $this->hasOne(Wadir3::class, 'id_wadir3', 'wadir3_id');
    }
}
