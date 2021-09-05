<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FileEventEksternalDetail extends Model
{
    protected $table = "file_event_eksternal_details";
    protected $primaryKey = "id_file_event_eksternal_detail";

    public function eventDetailRef()
    {
        return $this->belongsTo(EventEksternalDetail::class, 'event_eksternal_detail_id', 'id_event_eksternal_detail');
    }
}
