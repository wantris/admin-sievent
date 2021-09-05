<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pembina extends Model
{
    protected $primaryKey = "id_pembina";

    public function ormawaRef()
    {
        return $this->belongsTo(Ormawa::class, 'ormawa_id', 'id_ormawa');
    }
}
