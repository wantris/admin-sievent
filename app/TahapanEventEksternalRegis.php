<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TahapanEventEksternalRegis extends Model
{
    protected $primaryKey = "id_tahapan_event_regis";

    public function tahapanEventEksternal()
    {
        return $this->belongsTo(TahapanEventEksternal::class, 'tahapan_event_eksternal_id', 'id_tahapan_event_eksternal');
    }
}
