<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\EventInternal;
use App\FileEventInternalDetail;

class EventInternalDetail extends Model
{
    protected $primaryKey = "id_event_internal_detail";

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function eventInternalRef()
    {
        return $this->belongsTo(EventInternal::class, 'event_internal_id',  'id_event_internal');
    }

    public function filePengajuan()
    {
        return $this->hasMany(FileEventInternalDetail::class, 'event_internal_detail_id', 'id_event_internal_detail');
    }
}
