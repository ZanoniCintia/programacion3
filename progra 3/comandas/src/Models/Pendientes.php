<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pendiente extends Model {

    protected $table = 'pendientes';
    //protected $primaryKey = 'codigo';
    //public $incrementing = false;
    //protected $keyType = 'string';
    public $timestamps = false;

    const CREATED_AT = 'creation_date';
    const UPDATED_AT = 'last_update';
}