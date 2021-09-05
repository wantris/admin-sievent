<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventEksternalDetail extends Model
{
    protected $primaryKey = "id_event_eksternal_detail";

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function eventEksternalRef()
    {
        return $this->belongsTo(EventEksternal::class, 'event_eksternal_id',  'id_event_eksternal');
    }

    public function filePengajuan()
    {
        return $this->hasMany(FileEventEksternalDetail::class, 'event_eksternal_detail_id', 'id_event_eksternal_detail');
    }
}
