<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CakupanOrmawa extends Model
{
    protected $primaryKey = "id_cakupan_ormawa";

    public function ormawaRef()
    {
        return $this->belongsTo(Ormawa::class, 'ormawa_id', 'id_ormawa');
    }
}
