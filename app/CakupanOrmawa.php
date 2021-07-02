<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Ormawa;

class CakupanOrmawa extends Model
{
    protected $primaryKey = "id_cakupan_ormawa";

    public function ormawaRef()
    {
        return $this->hasOne(Ormawa::class,  'id_ormawa', 'ormawa_id');
    }
}
