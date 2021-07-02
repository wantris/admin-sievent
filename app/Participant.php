<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    protected $primaryKey = "id_participant";

    public function penggunaRef()
    {
        return $this->hasOne(Pengguna::class, 'participant_id', 'id_participant');
    }
}
