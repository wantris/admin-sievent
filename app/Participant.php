<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    protected $primaryKey = "id_participant";

    protected $casts = [
        'created_at' => 'datetime:Y-m-d',
    ];

    public function penggunaRef()
    {
        return $this->hasOne(Pengguna::class, 'participant_id', 'id_participant');
    }
}
