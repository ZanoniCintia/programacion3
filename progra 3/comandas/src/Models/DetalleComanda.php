<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleCom extends Model {

    protected $table = 'detallecomanda';
    //protected $primaryKey = 'idComanda';
    //public $incrementing = false;
    //protected $keyType = 'string';
    public $timestamps = false;

    const CREATED_AT = 'creation_date';
    const UPDATED_AT = 'last_update';
}