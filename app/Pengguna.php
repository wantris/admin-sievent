<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Wadir3;

class Pengguna extends Model
{
    protected $primaryKey = "id_pengguna";

    protected $appends = ['photo_image_url'];

    public function getPhotoImageUrlAttribute($value)
    {
        return request()->getSchemeAndHttpHost() . 'assets/img/photo-pengguna/' . $this->photo;
    }

    public function pembinaRef()
    {
        return $this->hasMany(Pembina::class, 'id_pembina', 'pembina_id');
    }

    public function participantRef()
    {
        return $this->hasOne(Participant::class, 'id_participant', 'participant_id');
    }

    public function wadir3Ref()
    {
        return $this->hasOne(Wadir3::class, 'id_wadir3', 'wadir3_id');
    }

    public function timMhsRef()
    {
        return $this->hasOne(TimEventDetail::class, 'nim', 'nim');
    }

    public function timParticipantRef()
    {
        return $this->hasOne(TimEventDetail::class, 'participant_id', 'participant_id');
    }
}
