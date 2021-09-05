<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FileEventInternalDetail extends Model
{
    protected $table = "file_event_internal_details";
    protected $primaryKey = "id_file_event_internal_detail";

    protected $appends = ['filename_url'];

    public function getFilenameUrlAttribute($value)
    {
        return request()->getSchemeAndHttpHost() . '/assets/file/pengajuan_event/' . $this->filename;
    }

    public function eventDetailRef()
    {
        return $this->belongsTo(EventInternalDetail::class, 'event_internal_detail_id', 'id_event_internal_detail');
    }
}
