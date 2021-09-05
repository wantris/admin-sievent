<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FileEventEksternalRegistration extends Model
{
    protected $table = "file_event_eksternal_regis";
    protected $primaryKey = "id_file_event_eksternal_regis";

    public function eventEksternalRegisRef(){
        $this->belongsTo(EventEksternalRegistration::class,'event_eksternal_regis_id','id_event_eksternal_registration');
    }
}
