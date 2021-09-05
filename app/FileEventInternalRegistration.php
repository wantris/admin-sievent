<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FileEventInternalRegistration extends Model
{
    protected $table = "file_event_internal_regis";
    protected $primaryKey = "id_file_event_internal_regis";

    public function eventInternalRegisRef(){
        $this->belongsTo(EventInternalRegistration::class,'event_internal_regis_id','id_event_internal_registration');
    }
}
